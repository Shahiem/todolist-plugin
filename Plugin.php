<?php
/**
 * Created by ShahiemSeymor.
 * Date: 6/19/14
 */

namespace ShahiemSeymor\Todo;

use App;
use Backend;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Todo Plugin / Task manager',
            'description' => 'This plugin allows backend users to manage projects and tasks.',
            'author'      => 'ShahiemSeymor',
            'icon'        => 'icon-check-square-o'
        ];
    }

    public function registerNavigation()
    {
        return [
            'todo' => [
                'label'       => 'Todo',
                'url'         => Backend::url('shahiemseymor/todo/projects'),
                'icon'        => 'icon-check-square-o',
                'order'       => 500,
                'sideMenu'    => [
                    'list'    => [
                        'label'       => 'Projects',
                        'icon'        => 'icon-tasks',
                        'url'         => Backend::url('shahiemseymor/todo/projects'),
                    ],
                ]

            ]
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'ShahiemSeymor\Todo\FormWidgets\Range' => [
                'label' => 'Range slider',
                'alias' => 'range'
            ],
            'ShahiemSeymor\Todo\FormWidgets\Tokeninput' => [
                'label' => 'Tokeninput',
                'alias' => 'tokeninput'
            ]
        ];
    }

}
