<?php

namespace Softworx\RocXolid\CMS\Elements;

use Illuminate\Foundation\AliasLoader;
// rocXolid service providers
use Softworx\RocXolid\AbstractServiceProvider as RocXolidAbstractServiceProvider;
// rocXolid rendering service contracts
use Softworx\RocXolid\Rendering\Services\Contracts\RenderingService;
// rocXolid cms rendering service contracts
use Softworx\RocXolid\CMS\Rendering\Services\ThemeRenderingService;
// rocXolid cms elements model viewers
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers;

/**
 * rocXolid CMS Elements package primary service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class ServiceProvider extends RocXolidAbstractServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Providers\ConfigurationServiceProvider::class);
        $this->app->register(Providers\ViewServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\TranslationServiceProvider::class);

        $this
            ->bindContracts()
            ->bindAliases(AliasLoader::getInstance());
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this
            ->publish();
    }

    /**
     * Expose config files and resources to be published.
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function publish(): RocXolidAbstractServiceProvider
    {
        // config files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\Elements\ServiceProvider" --tag="config" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../config/general.php' => config_path('rocXolid/cms-elements/general.php'),
        ], 'config');

        // lang files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\Elements\ServiceProvider" --tag="lang" (--force to overwrite)
        $this->publishes([
            //__DIR__ . '/../resources/lang' => resource_path('lang/vendor/softworx/rocXolid/cms-elements'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/rocXolid:cms-elements'), // used by laravel's FileLoaded::loadNamespaceOverrides()
        ], 'lang');

        // views files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\Elements\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/softworx/rocXolid/cms-elements'),
        ], 'views');

        // assets files
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\Elements\ServiceProvider" --tag="assets" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/softworx/rocXolid-cms-elements'),
        ], 'assets');

        // migrations
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\Elements\ServiceProvider" --tag="migrations" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        // db dumps
        // php artisan vendor:publish --provider="Softworx\RocXolid\CMS\Elements\ServiceProvider" --tag="dumps" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/dumps/' => database_path('dumps/rocXolid/cms-elements')
        ], 'dumps');

        return $this;
    }

    /**
     * Bind contracts / facades, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $this->app->bind(<SomeContract>::class, <SomeImplementation>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindContracts(): RocXolidAbstractServiceProvider
    {
        // @todo this doesn't work and setting this for each model viewer isn't the right way
        // $this->app->when(\Softworx\RocXolid\CMS\Rendering\Contracts\Themeable::class)
        $this->app->when([
                ModelViewers\SectionElementViewer::class,
                ModelViewers\GridRowElementViewer::class,
                ModelViewers\GridColumnElementViewer::class,
                ModelViewers\TextElementViewer::class,
            ])
            ->needs(RenderingService::class)
            ->give(function ($app) {
                return $app->make(ThemeRenderingService::class);
            });

        return $this;
    }

    /**
     * Bind aliases, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $loader->alias('<alias>', <Facade/>Contract>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindAliases(AliasLoader $loader): RocXolidAbstractServiceProvider
    {
        return $this;
    }
}
