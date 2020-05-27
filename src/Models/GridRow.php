<?php

namespace Softworx\RocXolid\CMS\Elements\Models;

// rocXolid cms models
use Softworx\RocXolid\CMS\Elements\Models\Abstraction\AbstractContainerElement;

/**
 * Grid row container component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class GridRow extends AbstractContainerElement
{
    /**
     * {@inheritDoc}
     */
    public function gridLayoutClass(): string
    {
        return 'row';
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetPreview(): string
    {
        return $this->getDocumentEditorComponentSnippetPreviewAssetPath(sprintf('grid-1x%s', $this->elements()->count()));
    }

    /**
     * {@inheritDoc}
     */
    public function getDocumentEditorComponentSnippetTitle(): string
    {
        if ($this->elements()->isEmpty()) {
            return $this->getModelViewerComponent()->translate('model.title.singular');
        }

        return sprintf(
            '%s, %s %s',
            $this->getModelViewerComponent()->translate('model.title.singular'),
            $this->elements()->count(),
            $this->elements()->first()->getModelViewerComponent()->translate(sprintf('model.title.%s', $this->elements()->count() > 1 ? 'plural' : 'singular'))
        );
    }

    /**
     * Option setting handler.
     * Set column elements to the row.
     *
     * @param integer $count
     */
    public function setColumns(int $count)
    {
        return $this->addFakeColumns($count);
    }

    /**
     * Add empty columns to the row.
     *
     * @param integer $count
     * @return \Softworx\RocXolid\CMS\Elements\Models\GridRow
     */
    protected function addFakeColumns(int $count)
    {
        $this->forgetElements();

        for ($i = 0; $i < $count; $i++) {
            $column = app(GridColumn::class)
                ->setDependenciesProvider($this->getDependenciesProvider())
                ->fill([
                    'grid_layout' => json_encode([
                        'xs' => (int)(12 / $count),
                        'sm' => (int)(12 / $count),
                        'md' => (int)(12 / $count),
                        'lg' => (int)(12 / $count),
                        'xl' => (int)(12 / $count),
                    ])
                ]);

            $this->elements()->push($column);
        }

        return $this;
    }
}
