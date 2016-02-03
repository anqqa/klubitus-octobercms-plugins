<?php namespace Klubitus\Forum;

use Backend;
use System\Classes\PluginBase;

/**
 * Forum Plugin Information File
 */
class Plugin extends PluginBase {

    public $require = [
        'Rainlab.User',
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name'        => 'Klubitus Forum',
            'description' => 'Forums for Klubitus.',
            'author'      => 'Antti Qvickström',
            'icon'        => 'icon-comments',
            'homepage'    => 'https://github.com/anqqa/klubitus-octobercms-plugins',
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Klubitus\Forum\Components\MyComponent' => 'myComponent',
        ];
    }


    public function registerSettings() {
        return [
            'settings' => [
                'label'       => 'Forum settings',
                'description' => 'Manage forum areas.',
                'category'    => 'Klubitus',
                'icon'        => 'icon-comments',
                'url'         => Backend::url('klubitus/forum/areas'),
                'order'       => 100,
            ]
        ];
    }

}
