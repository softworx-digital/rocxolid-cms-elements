<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

use Illuminate\Support\Collection;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits\HasImage;
use Softworx\RocXolid\Common\Models\Traits\HasFile;
// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;

/**
 * Text page element - most basic element.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Text extends AbstractComponentElement
{
    use HasImage;
    use HasFile;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'bookmark',
        'content',
    ];

    // @todo: put this into config to be project specific (and this declaration taken as default)
    protected $image_sizes = [
        'image' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            '1920x240' => [ 'width' => 1920, 'height' => 240, 'method' => 'fit', 'constraints' => [ ], ],
            '1920x700' => [ 'width' => 1920, 'height' => 700, 'method' => 'fit', 'constraints' => [ ], ],
            '540x' => [ 'width' => 540, 'method' => 'fit', 'constraints' => [ ], ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function setDataOnCreate(Collection $data): Element
    {
        $this->fill($data->toArray());

        return $this;
    }
}
