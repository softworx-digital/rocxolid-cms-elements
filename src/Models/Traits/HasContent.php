<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\ComponentElement;

/**
 * Trait for an element to enable content.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait HasContent
{
    /**
     * {@inheritDoc}
     */
    public function fillContent(Collection $data): ComponentElement
    {
        if ($data->has('content') && is_array($data->get('content'))) {
            $this->content = collect($data->get('content'))->toJson();
        } elseif ($data->has('content')) {
            $this->content = $data->get('content');
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent($part = null): string
    {
        $content = json_decode($this->content);

        if (json_last_error() == JSON_ERROR_NONE) {
            $content = collect($content)->get($part, null);
        } else {
            $content = $this->content;
        }

        return $content ?? '';
    }

    /**
     * {@inheritDoc}
     */
    public function isSetContent(?string $part = null): bool
    {
        if (!isset($this->content)) {
            return false;
        }

        $content = json_decode($this->content);

        if (json_last_error() == JSON_ERROR_NONE) {
            return collect($content)->has($part);
        }

        // the content is not JSON structured and we want it this way
        if (is_null($part)) {
            return true;
        }

        // accessing the content as JSON structure, but the content is unstructured
        throw new \RuntimeException(sprintf('Part [%s] is inaccessible, content of [%s][%s] is unstructured', $part, get_class($this), $this->getKey()));
    }

    /**
     * {@inheritDoc}
     */
    public function useDefaultContent(?string $part = null): bool
    {
        return !$this->getDependenciesDataProvider()->isReady();
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultContent(?string $part = null): string
    {
        return '(blank)';
    }
}
