<?php namespace Klubitus\BBCode\Classes;

use Decoda\Filter\UrlFilter as DecodaUrlFilter;

class UrlFilter extends DecodaUrlFilter {

    /**
     * Set target if outside current domain.
     *
     * @param array $tag
     * @param string $content
     * @return string
     */
    public function parse(array $tag, $content) {
        $host = array_get($_SERVER, 'HTTP_HOST', 'localhost');
        $url  = array_get($tag['attributes'], 'href', $content);

        if (!isset($tag['attributes']['target']) && strpos($url, $host) === false) {
            $tag['attributes']['target'] = '_blank';
        }

        return parent::parse($tag, $content);
    }

}
