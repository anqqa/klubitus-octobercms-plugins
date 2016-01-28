<?php namespace Klubitus\BBCode;

use Backend;
use Decoda;
use Klubitus\BBCode\Models\Emoticon as EmoticonModel;
use System\Classes\PluginBase;
use URL;


/**
 * BBCode Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name'        => 'BBCode',
            'description' => 'BBCode filter with custom tags.',
            'author'      => 'Klubitus',
            'icon'        => 'icon-bold'
        ];
    }


    public function registerMarkupTags() {
        return [
            'filters' => [
                'bbcode' => [$this, 'parse'],
            ],
        ];
    }


    public function registerSettings() {
        return [
            'emoticons' => [
                'label'       => 'Emoticons',
                'description' => 'Manage BBCode emoticons.',
                'category'    => 'Klubitus',
                'icon'        => 'icon-smile-o',
                'url'         => Backend::url('klubitus/bbcode/emoticons'),
            ]
        ];
    }


    public function parse($text, $plain = false) {
        static $fullParser, $plainParser;

        // Create parser if not already created
        if (($plain && !$plainParser) || (!$plain && !$fullParser)) {
            $parser = new Classes\BBCodeParser(null, [
                'escapeHtml'  => true,
                'maxNewLines' => 3,
                'strictMode'  => false,
                'xhtmlOutput' => false,
            ]);

            // Custom hooks and filters
            $parser->addHook(new Classes\EmoticonHook([
                'path'      => '/',
                'extension' => '',
                'emoticons' => EmoticonModel::getEmoticons(),
            ]));
            $parser->addHook(new Classes\ClickableHook());
            $plain or $parser->addFilter(new Classes\AudioFilter());
            $plain or $parser->addFilter(new Classes\VideoFilter());
            $parser->addFilter(new Classes\UrlFilter());

            // Decoda hooks and filters
            $parser->addFilter(new Decoda\Filter\DefaultFilter());
            $parser->addFilter(new Decoda\Filter\BlockFilter());
            $parser->addFilter(new Decoda\Filter\EmailFilter());
            $plain or $parser->addFilter(new Decoda\Filter\ImageFilter());
            $parser->addFilter(new Decoda\Filter\ListFilter());
            $parser->addFilter(new Decoda\Filter\QuoteFilter());

            if ($plain) {
                $plainParser = $parser;
            }
            else {
                $fullParser = $parser;
            }
        }
        else {
            $parser = $plain ? $plainParser : $fullParser;
        }

        $parser->setString($text);

        return $parser->parse();
    }
}
