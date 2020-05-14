<?php

namespace Softworx\RocXolid\CMS\Elements\Components\ModelViewers;

use Illuminate\Database\Eloquent\Model;
// rocXolid component contracts
use Softworx\RocXolid\Components\AbstractComponent;
// rocXolid componentable contracts
use Softworx\RocXolid\Components\Contracts\Componentable\HigherOrderComponent;
use Softworx\RocXolid\Components\Contracts\Componentable\ModelViewer as ModelViewerComponentable;
// rocXolid component traits
use Softworx\RocXolid\Components\Traits\HasModelViewerComponent;
// rocXolid cms elements model viewer components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\CrudModelViewer;

/**
 * Special model viewer used for rendering snippets for document editor.
 * Serves as Higher Order Component.
 * Contains true model viewer for rendering true themed templates.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class SnippetModelViewer extends CrudModelViewer implements HigherOrderComponent, ModelViewerComponentable
{
    use HasModelViewerComponent;

    /**
     * Provide HTML data attributes to be used in document editor snippets wrapper.
     *
     * @return string
     */
    public function getElementSnippetDataAttributes(): string
    {
        $model = $this->getModel();

        return collect([
            'data-type' => $model->getDocumentEditorComponentType(),
            'data-preview' => $model->getDocumentEditorComponentSnippetPreview(),
            'data-keditor-title' => $model->getDocumentEditorComponentSnippetTitle(),
            'data-keditor-categories' => $model->getDocumentEditorComponentSnippetCategories()->join(';'),
        ])->filter()->map(function ($value, $attribute) {
            return sprintf('%s="%s"', $attribute, $value);
        })->join(' ');
    }

    /**
     * Provide HTML data attributes to be used in document editor templates for element identification.
     * This is called by snippet model viewer only when rendering snippets.
     *
     * @return string
     */
    public function getElementDataAttributes(): string
    {
        $model = $this->getModel();

        return collect([
            'data-element-type' => $model->getElementTypeParam(),
            'data-element-id' => $model->getKey(),
        ])->filter()->map(function ($value, $attribute) {
            return sprintf('%s="%s"', $attribute, $value);
        })->join(' ');
    }

    /**
     * Provide CSS class to the element.
     *
     * @return string
     */
    public function getElementCssClass(): string
    {
        return $this->getWrappedComponent()->getElementCssClass();
    }

    /**
     * {@inheritDoc}
     */
    public function getModel(): Model
    {
        return $this->getWrappedComponent()->getModel();
    }

    /**
     * {@inheritDoc}
     */
    public function setWrappedComponent(AbstractComponent $model_viewer_component): HigherOrderComponent
    {
        return $this->setModelViewerComponent($model_viewer_component);
    }

    /**
     * {@inheritDoc}
     */
    public function getWrappedComponent(): AbstractComponent
    {
        return $this->getModelViewerComponent();
    }

    /**
     * {@inheritDoc}
     */
    public function hasWrappedComponent(): bool
    {
        return $this->hasModelViewerComponent();
    }
}
