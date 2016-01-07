<?php namespace Klubitus\User;

use Backend;
use System\Classes\PluginBase;

/**
 * User Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Klubitus User',
            'description' => 'RainLab.User extended for Klubitus.',
            'author'      => 'Antti Qvickström',
            'icon'        => 'icon-user',
            'homepage'    => 'https://github.com/anqqa/klubitus-octobercms-plugins',
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
            'Klubitus\User\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'klubitus.user.some_permission' => [
                'tab' => 'User',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'user' => [
                'label'       => 'User',
                'url'         => Backend::url('klubitus/user/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['klubitus.user.*'],
                'order'       => 500,
            ],
        ];
    }

}
