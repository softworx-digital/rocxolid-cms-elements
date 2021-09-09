<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\DisplayRulesProvider;

/**
 * Text CMS element.
 * Most basic and versatile element.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class Text extends AbstractComponentElement implements DisplayRulesProvider
{
    use Traits\HasDisplayRules;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'bookmark',
        'content',
        'meta_data',
    ];

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetPreview(): string
    {
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('text');
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultContent(?string $part = null): string
    {
        return \Faker\Factory::create('en_US')->realText();
    }
}
