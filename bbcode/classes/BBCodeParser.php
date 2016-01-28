<?php namespace Klubitus\BBCode\Classes;

use Decoda\Decoda;

class BBCodeParser extends Decoda {

    /**
     * Set to-be-parsed string allowing reuse of parser.
     *
     * @param  $string
     */
    public function setString($string) {
        $string = $this->escapeHtml($string);

        if ($this->_string !== $string) {
            $this->_parsed   = '';
            $this->_stripped = '';
            $this->_string   = $string;
        }
    }

}
