<?php

namespace Softworx\RocXolid\CMS\Elements\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid cms elements package provider
use Softworx\RocXolid\CMS\Elements\ServiceProvider as PackageServiceProvider;

/**
 * rocXolid views & composers service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class ViewServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid view services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load()
            ->setComposers()
            ->setDirectives();

        return $this;
    }

    /**
     * Load views.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(): IlluminateServiceProvider
    {
        // customized views preference
        $this->loadViewsFrom(PackageServiceProvider::viewsPublishPath(), 'rocXolid:cms-elements');
        // pre-defined views fallback
        $this->loadViewsFrom(PackageServiceProvider::viewsSourcePath(dirname(dirname(__DIR__))), 'rocXolid:cms-elements');

        return $this;
    }

    /**
     * Set view composers for blade templates.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function setComposers(): IlluminateServiceProvider
    {
        foreach (config('rocXolid.cms-elements.general.composers', []) as $view => $composer) {
            View::composer($view, $composer);
        }

        return $this;
    }

    /**
     * Set Blade directives extensions.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function setDirectives(): IlluminateServiceProvider
    {
        /*
        Blade::directive('test', function ($args) {
return "<?php \Softworx\RocXolid\CMS\Elements\Providers\ViewServiceProvider::aaa($args); ?>";
        });
        */

        return $this;
    }
}
