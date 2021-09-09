<?php

namespace Softworx\RocXolid\CMS\Elements\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
// rocXolid services
use Softworx\RocXolid\Services\CrudRouterService;

/**
 * rocXolid CMS Elements routes service provider.
 * Registers routes related to cms content elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class ElementRouterService extends CrudRouterService
{
    protected function registerPackageRoutes(string $param): CrudRouterService
    {
        /*
        Route::get($this->name . sprintf('/{%s}/settings', $param), [
            'as' => 'crud.' . $this->name . '.settings',
            'uses' => $this->controller . '@settings',
        ]);
        */

        return $this;
    }

    protected function getParam(): string
    {
        return sprintf('cms_element_%s', Str::snake($this->param));
    }

    protected function getOptions(): array
    {
        return parent::getOptions() + [
            'parameters' => [
                $this->name => $this->getParam(),
            ],
        ];
    }
}
