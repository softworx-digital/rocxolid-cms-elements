<?php

namespace Softworx\RocXolid\CMS\Elements\Components\SnippetModelViewers;

use Illuminate\Database\Eloquent\Model;
// rocXolid component contracts
use Softworx\RocXolid\Components\AbstractComponent;
// rocXolid componentable contracts
use Softworx\RocXolid\Components\Contracts\Componentable\HigherOrderComponent;
use Softworx\RocXolid\Components\Contracts\Componentable\ModelViewer as ModelViewerComponentable;
// rocXolid component traits
use Softworx\RocXolid\Components\Traits\HasModelViewerComponent;
// rocXolid cms elements model viewers
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

    public function getElementSnippetDataAttributes(): string
    {
        return collect([
            'data-type' => $this->getWrappedComponent()->getModel()->getDocumentEditorComponentType(),
            'data-preview' => 'https://github.com/Kademi/keditor/raw/master/examples/snippets/preview/row_12.png',
            'data-keditor-title' => $this->getWrappedComponent()->translate('model.title.singular'),
            'data-keditor-categories' => 'Grid',
            // 'data-element-type' => $this->getWrappedComponent()->getModel()->getElementTypeParam(),
            // 'data-element-id' => $this->getWrappedComponent()->getModel()->getKey(),
        ])->filter()->map(function ($value, $attribute) {
            return sprintf('%s="%s"', $attribute, $value);
        })->join(' ');
    }

    public function getElementDataAttributes(): string
    {
        // return '';

        return collect([
            'data-element-type' => $this->getWrappedComponent()->getModel()->getElementTypeParam(),
            'data-element-id' => $this->getWrappedComponent()->getModel()->getKey(),
        ])->filter()->map(function ($value, $attribute) {
            return sprintf('%s="%s"', $attribute, $value);
        })->join(' ');
    }

    public function getModel(): Model
    {
        return $this->getWrappedComponent()->getModel();
    }

    public function setWrappedComponent(AbstractComponent $model_viewer_component): HigherOrderComponent
    {
        return $this->setModelViewerComponent($model_viewer_component);
    }

    public function getWrappedComponent(): AbstractComponent
    {
        return $this->getModelViewerComponent();
    }

    public function hasWrappedComponent(): bool
    {
        return $this->hasModelViewerComponent();
    }
}
