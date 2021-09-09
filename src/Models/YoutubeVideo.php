<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractComponentElement;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\DisplayRulesProvider;

/**
 * Image CMS element.
 * Represents single image.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class YoutubeVideo extends AbstractComponentElement implements DisplayRulesProvider
{
    use Traits\HasDisplayRules;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'bookmark',
        'content',
        'url',
        'meta_data',
    ];

    public function onUpdateBeforeSave(Collection $data): Crudable
    {
        preg_match('/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&"\'>]+)/', $this->url, $matches);

        $this->youtube_video_id = $matches[1];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorElementSnippetPreview(): string
    {
        return $this->getDocumentEditorElementSnippetPreviewAssetPath('youtube');
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsUrl(): ?string
    {
        if ($user = auth('rocXolid')->user()) {
            if ($this->exists && $user->can('update', $this)) {
                return $this->getControllerRoute('edit');
            }
        }

        return null;
    }
}
