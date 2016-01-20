<?php namespace Klubitus\BBCode\Classes;

use Decoda\Hook\ClickableHook as DecodaClickableHook;

class ClickableHook extends DecodaClickableHook {

    /**
     * Matches an orphan link without protocol and prefixes it.
     *
     * @param  string  $content
     * @return  string
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


    /**
     * Callback for URL processing.
     *
     * @param array $matches
     * @return string
     */
    protected function _urlCallback($matches) {
        if ($matches[1] === '<br>' || $matches[1] === '<br/>') {
            $matches[0] = $matches[2];
        } else if ($matches[1] !== '') {
            return $matches[0];
        }

        $url = trim($matches[0]);

        // Parse video and audio links
        $parser = $this->getParser();
        if ($parser->hasFilter('Audio')) {
            if (preg_match('/mixcloud\.com|soundcloud\.com|spotify\.com/', $url)) {
                return $matches[1] . $parser->getFilter('Audio')->parse([
                    'tag'        => 'audio',
                    'attributes' => [],
                ], $url);
            }
        }

        if ($parser->hasFilter('Audio')) {
            $patterns = [
                '/^https?:\/\/(?:www\.)?vimeo\.com\/(?<id>[0-9]+).*$/i' => 'vimeo',
                '/^https?:\/\/(?:[a-z0-9\.]*youtube\.com)\/watch\?v=(?<id>[^"&]+).*$/i' => 'youtube',
                '/^https?:\/\/youtu\.be\/(?<id>[^"&\?]+).*$/i' => 'youtube',
            ];
            foreach ($patterns as $pattern => $tag) {
                if (preg_match($pattern, $url, $ids)) {
                    return $matches[1] . $parser->getFilter('Video')->parse([
                        'tag'        => $tag,
                        'attributes' => [],
                    ], $ids['id']);
                }
            }
        }

        return $matches[1] . $parser->getFilter('Url')->parse([
            'tag'        => 'url',
            'attributes' => []
        ], $url);
    }

}
