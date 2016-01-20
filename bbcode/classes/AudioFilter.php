<?php namespace Klubitus\BBCode\Classes;

use Decoda\Decoda;
use Decoda\Filter\AbstractFilter;

/**
 * Provides the tag for videos. Only a few video services are supported.
 */
class AudioFilter extends AbstractFilter {

    /**
     * Regex pattern.
     */
    const SIZE_PATTERN = '/^(?:small|medium|large)$/i';

    /**
     * Supported tags.
     *
     * @type  array
     */
    protected $_tags = array(
        'audio' => array(
            'template'     => 'video',
            'displayType'  => Decoda::TYPE_BLOCK,
            'allowedTypes' => Decoda::TYPE_NONE,
            'attributes'   => array(
                'default' => true,
                'size'    => self::SIZE_PATTERN
            )
        ),
    );


    /**
     * Audio formats.
     *
     * @type  array
     */
    protected $_formats = array(
        'mixcloud' => [
            'small'   => ['100%', 60,  '//www.mixcloud.com/widget/iframe/?feed=http%3A%2F%2Fwww.mixcloud.com%2F$1%2F$2%2F&amp;replace=0&amp;hide_cover=1&amp;hide_tracklist=1&amp;mini=1&amp;embed_type=widget_standard'],
            'medium'  => ['100%', 180, '//www.mixcloud.com/widget/iframe/?feed=http%3A%2F%2Fwww.mixcloud.com%2F$1%2F$2%2F&amp;replace=0&amp;hide_cover=1&amp;hide_tracklist=1&amp;mini=0&amp;embed_type=widget_standard'],
            'large'   => ['100%', 180, '//www.mixcloud.com/widget/iframe/?feed=http%3A%2F%2Fwww.mixcloud.com%2F$1%2F$2%2F&amp;replace=0&amp;hide_cover=1&amp;hide_tracklist=1&amp;mini=0&amp;embed_type=widget_standard'],
            'player'  => 'iframe',
            'pattern' => '/^https?:\/\/www\.mixcloud\.com\/([^\/]+)\/([^\/]+)\/?$/i',
        ],
        'soundcloud' => [
            'small'   => [300, 166,    '//w.soundcloud.com/player/?url=https%3A%2F%2Fsoundcloud.com%2F$1%2F$2&amp;auto_play=false&amp;show_user=true&amp;show_artwork=true'],
            'medium'  => ['100%', 166, '//w.soundcloud.com/player/?url=https%3A%2F%2Fsoundcloud.com%2F$1%2F$2&amp;auto_play=false&amp;show_user=true&amp;show_artwork=true'],
            'large'   => ['100%', 380, '//w.soundcloud.com/player/?url=https%3A%2F%2Fsoundcloud.com%2F$1%2F$2&amp;auto_play=false&amp;show_user=true&amp;show_artwork=true&amp;visual=true'],
            'player'  => 'iframe',
            'pattern' => '/^https?:\/\/soundcloud\.com\/([^\/]+)\/([^\/]+)\/?$/i',
        ],
        'soundcloud_user' => [
            'small'   => [300, 166,    '//w.soundcloud.com/player/?url=https%3A%2F%2Fsoundcloud.com%2F$1&amp;auto_play=false&amp;show_artwork=true&amp;show_user=true'],
            'medium'  => ['100%', 166, '//w.soundcloud.com/player/?url=https%3A%2F%2Fsoundcloud.com%2F$1&amp;auto_play=false&amp;show_artwork=true&amp;show_user=true'],
            'large'   => ['100%', 380, '//w.soundcloud.com/player/?url=https%3A%2F%2Fsoundcloud.com%2F$1&amp;auto_play=false&amp;show_artwork=true&amp;show_user=true&amp;visual=true'],
            'player'  => 'iframe',
            'pattern' => '/^https?:\/\/soundcloud\.com\/([^\/]+)\/?$/i',
        ],
        'spotify' => [
            'small'   => [300, 80,  '//embed.spotify.com/?uri=spotify:$1$3:$2$4'],
            'medium'  => [300, 80,  '//embed.spotify.com/?uri=spotify:$1$3:$2$4'],
            'large'   => [300, 380, '//embed.spotify.com/?uri=spotify:$1$3:$2$4'],
            'player'  => 'iframe',
            'pattern' => '/^(?:https?:\/\/open\.spotify\.com\/(track|album)\/(\w+))|(?:spotify:(track|album):(\w+))$/i',
        ],
        'spotify_playlist' => [
            'small'   => [300, 80,  '//embed.spotify.com/?uri=spotify:user:$1$3:playlist:$2$4'],
            'medium'  => [300, 80,  '//embed.spotify.com/?uri=spotify:user:$1$3:playlist:$2$4'],
            'large'   => [300, 380, '//embed.spotify.com/?uri=spotify:user:$1$3:playlist:$2$4'],
            'player'  => 'iframe',
            'pattern' => '/^(?:https?:\/\/open\.spotify\.com\/user\/([^\/]+)\/playlist\/(\w+))|(?:spotify:user:([^:]+):playlist:(\w+))$/i',
        ],
    );


    /**
     * Custom build the HTML for audios.
     *
     * @param   array   $tag
     * @param   string  $content
     * @return  string
     */
    public function parse(array $tag, $content) {
        $size = mb_strtolower(isset($tag['attributes']['size']) ? $tag['attributes']['size'] : 'medium');

        foreach ($this->_formats as $format) {
            if (preg_match($format['pattern'], $content)) {
                $tag['attributes']['width'] = $format[$size][0];
                $tag['attributes']['height'] = $format[$size][1];
                $tag['attributes']['player'] = $format['player'];
                $tag['attributes']['url'] = preg_replace($format['pattern'], $format[$size][2], $content);

                return parent::parse($tag, $content);
            }
        }

        return '[url]' . $content . '[/url]';
    }

}
