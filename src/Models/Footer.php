<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Footer wrapper page element.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Footer extends AbstractContainerElement
{
    // use Traits\HasContent;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'bookmark',
        'content',
        'meta_data',
    ];

    // @todo put this into config to be project specific (and this declaration taken as default)
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
    public function gridLayoutClass(): string
    {
        return 'footer';
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer(): Element
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetPreview(): string
    {
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('footer');
    }
}
