<?php namespace Klubitus\BBCode\Classes;

use Decoda\Decoda;
use Decoda\Filter\VideoFilter as DecodaVideoFilter;

class VideoFilter extends DecodaVideoFilter {

    /**
     * Custom build the HTML for videos with responsive sizes.
     *
     * @param   array   $tag
     * @param   string  $content
     * @return  string
     */
    public function parse(array $tag, $content) {
        array_walk($this->_formats, function(&$item) {
            foreach (['small', 'medium', 'large'] as $size) {
                $item[$size][0] = '100%';
            }
        });

        return parent::parse($tag, $content);
    }

}
