<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\DisplayRulesProvider;

/**
 * Gallery CMS element.
 * Represents collection of images.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Gallery extends AbstractComponentElement implements DisplayRulesProvider
{
    use Traits\HasDisplayRules;
     use CommonTraits\HasImages;

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
        'images' => [
            'icon' => [ 'width' => 70, 'height' => 70, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            'small' => [ 'width' => 256, 'height' => 256, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small-square' => [ 'width' => 256, 'height' => 256, 'method' => 'fit', 'constraints' => [ 'upsize', ], ],
            '1920x700' => [ 'width' => 1920, 'height' => 700, 'method' => 'fit', 'constraints' => [ ], ],
            '900x' => [ 'width' => 900, 'method' => 'fit', 'constraints' => [ ], ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetPreview(): string
    {
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('gallery');
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsUrl(): ?string
    {
        if ($user = auth('rocXolid')->user()) {
            if ($this->exists && $user->can('update', $this)) {
                return $this->getControllerRoute('show');
            }
        }

        return null;
    }
}
