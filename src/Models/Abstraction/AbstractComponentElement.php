<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms elements models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractElement;

/**
 * Abstraction for component element models.
 * Components cannot have any containees.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractComponentElement extends AbstractElement
{
    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentType(): string
    {
        return sprintf('component-%s', $this->getElementTypeParam());
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetTitle(): string
    {
        return $this->getModelViewerComponent()->translate(sprintf('model.title.%s', $this->getTemplate()));
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetCategories(): Collection
    {
        return collect($this->getModelViewerComponent()->translations('elementable.categories'));
    }

    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return 'element';
    }

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return sprintf('cms_component_%s', $this->getTableBaseName());
    }

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        if ($data->has('content') && is_array($data->get('content'))) {
            // $content = collect($data->get('content'));
            // $data->put('content', ($content->count() > 1) ? $content->toJson() : $content->first());
            $data->put('content', collect($data->get('content'))->toJson());
        }

        $this->fill($data->toArray());

        return $this;
    }

    /**
     * Retrieve the content (part).
     *
     * @param string|null $part
     * @return string
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
     * Check if content (part) is set to element.
     *
     * @param string|null $part
     * @return bool
     * @throws \RuntimeException
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
     * Decide whether to use default value for content (part).
     *
     * @param string|null $part
     * @return boolean
     */
    public function useDefaultContent(?string $part = null): bool
    {
        return !$this->getDependenciesDataProvider()->isReady();
    }

    /**
     * Obtain default element content.
     *
     * @return string
     */
    public function getDefaultContent(?string $part = null): string
    {
        return '(blank)';
    }
}
