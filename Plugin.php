<?php 

declare(strict_types=1);

namespace Devinside\Telescope;

use Backend;
use Laravel\Telescope\Telescope;
use System\Classes\PluginBase;

/**
 * Telescope Plugin Information File
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
            'name'        => 'Telescope',
            'description' => 'Laravel Telescope integration for October CMS',
            'author'      => 'Devinside',
            'iconSvg'     => 'plugins/devinside/telescope/telescope/icon',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/telescope.php', 'telescope'
        );

        app()->register(\Illuminate\Auth\AuthServiceProvider::class);
        app()->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        app()->register(\Devinside\Telescope\Classes\Providers\TelescopeServiceProvider::class);

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        if (config('devinside.telescope::dark_mode')) {
            Telescope::night();
        }
    }

    public function registerSchedule($schedule): void
    {
        $schedule->command('telescope:prune')->daily();
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions(): array
    {
        return [
            'devinside.telescope.access' => [
                'tab'   => 'Telescope',
                'label' => 'Access to the Telescope dashboard',
                'roles' => ['developer'],
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation(): array
    {
        return [
            'telescope' => [
                'label' => 'Telescope',
                'url' => Backend::url('devinside/telescope/telescope'),
                'iconSvg' => '/plugins/devinside/telescope/assets/telescope.svg',
                'order' => 500,
                'permissions' => ['devinside.telescope.access'],
            ]
        ];
    }
}
