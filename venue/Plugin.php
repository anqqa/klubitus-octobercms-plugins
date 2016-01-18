<?php namespace Klubitus\Venue;

use Backend;
use System\Classes\PluginBase;


/**
 * Venues Plugin Information File
 */
class Plugin extends PluginBase {

    public $require = [
        'Klubitus.Calendar',
        'RainLab.User'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name'        => 'Klubitus Venue',
            'description' => 'Venues for Klubitus Calendar events.',
            'author'      => 'Klubitus',
            'icon'        => 'icon-map-marker'
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
            'Klubitus\Venue\Components\MyComponent' => 'myComponent',
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
            'klubitus.venues.some_permission' => [
                'tab' => 'Venue',
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
            'venues' => [
                'label'       => 'Venue',
                'url'         => Backend::url('klubitus/venue/mycontroller'),
                'icon'        => 'icon-map-marker',
                'permissions' => ['klubitus.venue.*'],
                'order'       => 500,
            ],
        ];
    }

}
