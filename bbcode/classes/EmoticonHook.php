<?php namespace Klubitus\BBCode\Classes;

use Decoda\Hook\EmoticonHook as DecodaEmoticonHook;
use October\Rain\Support\Arr;

class EmoticonHook extends DecodaEmoticonHook {

    /**
     * Read the contents of the loaders into the emoticons list.
     */
    public function startup() {
        if ($this->_emoticons) {
            return;
        }

        $this->_emoticons = $this->getConfig('emoticons');

        foreach ($this->_emoticons as $path => $notations) {
            foreach ($notations as $smiley) {
                $this->_smilies[$smiley] = $path;
            }
        }
    }


    /**
     * Convert a smiley to an HTML representation.
     *
     * @param string $smiley
     * @param bool $isXhtml
     * @return string
     */
    public function render($smiley, $isXhtml = true) {
        if (!$this->hasSmiley($smiley)) {
            return null;
        }

        if ($isXhtml) {
            $tpl = '<img src="%s" alt="" title="%s" />';
        } else {
            $tpl = '<img src="%s" alt="" title="%s">';
        }

        return sprintf($tpl, $this->_smilies[$smiley], $smiley);
    }

}
