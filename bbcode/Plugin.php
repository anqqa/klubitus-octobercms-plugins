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


    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return []; // Remove this line to activate

        return [
            'Klubitus\BBCode\Components\MyComponent' => 'myComponent',
        ];
    }


    public function registerMarkupTags() {
        return [
            'filters' => [
                'bbcode' => [$this, 'parse'],
            ],
        ];
    }


    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return []; // Remove this line to activate

        return [
            'klubitus.bbcode.some_permission' => [
                'tab' => 'BBCode',
                'label' => 'Some permission'
            ],
        ];
    }


    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation() {
        return []; // Remove this line to activate

        return [
            'bbcode' => [
                'label'       => 'BBCode',
                'url'         => Backend::url('klubitus/bbcode/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['klubitus.bbcode.*'],
                'order'       => 500,
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


    public function parse($text) {
        $decoda = new Decoda\Decoda($text, [
            'escapeHtml'  => true,
            'maxNewLines' => 3,
            'strictMode'  => false,
            'xhtmlOutput' => false,
        ]);

        // Custom hooks and filters
        $decoda->addHook(new Classes\EmoticonHook([
            'path'      => '/',
            'extension' => '',
            'emoticons' => EmoticonModel::getEmoticons(),
        ]));
        $decoda->addHook(new Classes\ClickableHook());
        $decoda->addFilter(new Classes\UrlFilter());

        // Decoda hooks and filters
        $decoda->addFilter(new Decoda\Filter\DefaultFilter());
        $decoda->addFilter(new Decoda\Filter\BlockFilter());
        $decoda->addFilter(new Decoda\Filter\EmailFilter());
        $decoda->addFilter(new Decoda\Filter\ImageFilter());
        $decoda->addFilter(new Decoda\Filter\ListFilter());
        $decoda->addFilter(new Decoda\Filter\QuoteFilter());
        $decoda->addFilter(new Decoda\Filter\VideoFilter());

        return $decoda->parse();
    }
}
