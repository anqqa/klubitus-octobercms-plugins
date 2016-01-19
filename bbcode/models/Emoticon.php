<?php namespace Klubitus\BBCode\Models;

use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Emoticon Model
 */
class Emoticon extends Model {
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'emoticons';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'emoticon',
        'notation',
        'is_secret',
    ];

    protected $jsonable = [
        'notation'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'emoticon' => ['System\Models\File']
    ];
    public $attachMany = [];

    public $rules = [
        'name'     => 'required',
        'notation' => 'required',
    ];


    public static function getEmoticons() {
        $images    = Emoticon::get();
        $emoticons = [];

        foreach ($images as $image) {
            $notations = array_pluck($image->notation, 'notation');
            $path      = $image->emoticon->getPath();

            $emoticons[$path] = $notations;
        }

        return $emoticons;
    }

}
