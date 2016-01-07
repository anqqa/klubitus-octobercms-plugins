<?php namespace Klubitus\User\Classes;

use Config;
use RainLab\User\Models\User;

class KohanaAuth {

    /**
     * Check plain text password against hash.
     *
     * @param   string  $password
     * @param   string  $hashedPassword
     * @return  boolean
     */
    public static function check($password, $hashedPassword) {
        $salt = self::salt($hashedPassword);

        return self::hashPassword($password, $salt) === $hashedPassword;
    }


    /**
     * Creates a hashed password from a plaintext password, inserting salt
     * based on the configured salt pattern.
     *
     * @param   string          $password  plaintext
     * @param   string|boolean  $salt
     * @return  string
     */
    private static function hashPassword($password, $salt = false) {
        $saltPattern = Config::get('klubitus.user::salt_pattern', array(1, 2, 3));
        $hashMethod  = Config::get('klubitus.user::hash_method',  'sha1');

        // Create a salt seed, same length as the number of offsets in the pattern
        if ($salt === false) {
            $salt = substr(hash($hashMethod, uniqid(null, true)), 0, count($saltPattern));
        }

        // Password hash that the salt will be inserted into
        $hash = hash($hashMethod, $salt . $password);

        // Change salt to an array
        $salt = str_split($salt, 1);

        // Returned password
        $password = '';

        // Used to calculate the length of splits
        $last_offset = 0;

        foreach ($saltPattern as $offset) {

            // Split a new part of the hash off
            $part = substr($hash, 0, $offset - $last_offset);

            // Cut the current part out of the hash
            $hash = substr($hash, $offset - $last_offset);

            // Add the part to the password, appending the salt character
            $password .= $part . array_shift($salt);

            // Set the last offset to the current offset
            $last_offset = $offset;

        }

        // Return the password, with the remaining hash appended
        return $password . $hash;
    }


    /**
     * Migrate auth from Kohana to Laravel/OctoberCMS.
     *
     * @param  string  $login     Username or email
     * @param  string  $password
     * @return  bool  Migrated
     */
    public static function migrate($login, $password) {
        if (!$login || !$password) {
            return false;
        }

        if (!$user = User::where('username', $login)->orWhere('email', $login)->first()) {
            return false;
        }

        if (!$user->password && self::check($password, $user->password_kohana)) {
            $user->password = $user->password_confirmation = $password;
            $user->forceSave();

            return true;
        }

        return false;
    }


    /**
     * Finds the salt from a password, based on the configured salt pattern.
     *
     * @param   string  $password  hashed
     * @return  string
     */
    private static function salt($password) {
        $saltPattern = Config::get('klubitus.user::salt_pattern', array(1, 2, 3));
        $salt        = '';

        // Find salt characters, take a good long look...
        foreach ($saltPattern as $i => $offset) {
            $salt .= substr($password, $offset + $i, 1);
        }

        return $salt;
    }

}
