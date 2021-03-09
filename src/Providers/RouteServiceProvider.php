<?php

namespace Softworx\RocXolid\CMS\Elements\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid services
use Softworx\RocXolid\CMS\Elements\Services\ElementRouterService;

/**
 * rocXolid routes service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class RouteServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid routing services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load($this->app->router)
            ->mapRouteModels($this->app->router);

        return $this;
    }

    /**
     * Define the routes for the package.
     *
     * @param \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(Router $router): IlluminateServiceProvider
    {
        $router->group([
            'module' => 'rocXolid-cms-elements',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\CMS\Elements\Http\Controllers',
            'prefix' => sprintf('%s/cms/elements', config('rocXolid.admin.general.routes.root', 'rocXolid')),
            'as' => 'rocXolid.cms.elements.',
        ], function ($router) {
            // ElementRouterService::create('section', \Section\Controller::class);
            ElementRouterService::create('grid-row', \GridRow\Controller::class);
            ElementRouterService::create('text', \Text\Controller::class);
        });

        return $this;
    }

    /**
     * Define the route bindings for URL params.
     *
     * @param \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function mapRouteModels(Router $router): IlluminateServiceProvider
    {
        // $router->model('section', \Softworx\RocXolid\CMS\Elements\Models\Section::class);
        $router->model('grid_row', \Softworx\RocXolid\CMS\Elements\Models\GridRow::class);
        $router->model('text', \Softworx\RocXolid\CMS\Elements\Models\Text::class);

        return $this;
    }
}
