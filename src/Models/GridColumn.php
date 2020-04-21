<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Grid column container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class GridColumn extends AbstractContainerElement
{
    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'grid_layout',
    ];

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentType(): string
    {
        return 'container-content';
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->fill([
            'grid_layout' => collect($data->get('gridLayout'))->toJson(),
        ]);

        return $this;
    }

    /**
     * Make bootstrap column breakpoints.
     *
     * @return string
     */
    public function gridLayout(): string
    {
        return collect(json_decode($this->grid_layout, true))->map(function ($size, $breakpoint) {
            return sprintf('col-%s-%s', $breakpoint, $size);
        })->join(' ');
    }
}
