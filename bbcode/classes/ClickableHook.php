<?php namespace Klubitus\BBCode\Classes;

use Decoda\Hook\ClickableHook as DecodaClickableHook;

class ClickableHook extends DecodaClickableHook {

    /**
     * Matches a link or an email, and converts it to an anchor tag.
     *
     * @param string $content
     * @return string
     */
    public function afterParse($content) {
        $parser = $this->getParser();

        // Add default protocol to orphan www. urls
        if ($parser->hasFilter('Url')) {
            $protocol = $parser->getFilter('Url')->getConfig('defaultProtocol');

            $content = str_replace('www.', $protocol . '://www.', $content);
            $content = str_replace('://' . $protocol . '://', '://', $content);
        }

        return parent::afterParse($content);
    }

}
