<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Paramable;
use Softworx\RocXolid\Contracts\Optionable;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Cloneable;
// rocXolid cms elements model viewer components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\SnippetModelViewer;

/**
 * Interface for model to be used as element for eg. page or document.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface Element extends Paramable, Optionable, Cloneable
{
    /**
     * Obtain element type parameter for polymorphic mapping.
     *
     * @return string
     */
    public function getElementTypeParam(): string;

    /**
     * Obtain element type as used in document editor.
     * Mapping between internal CMS elements and document editor components.
     *
     * @return string
     */
    public function getDocumentEditorComponentType(): string;

    /**
     * Obtain snippet preview image used in document editor element addition.
     *
     * @return string
     */
    public function getDocumentEditorComponentSnippetPreview(): string;

    /**
     * Obtain snippet preview title used in document editor element addition.
     *
     * @return string
     */
    public function getDocumentEditorComponentSnippetTitle(): string;

    /**
     * Obtain snippet categories used in document editor element addition.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDocumentEditorComponentSnippetCategories(): Collection;

    /**
     * Set data from pivot so it can be used on frontpage and elsewhere.
     *
     * @param \Illuminate\Support\Collection $pivot_data
     * @return Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function setPivotData(Collection $pivot_data): Element;

    /**
     * Retrieve pivot data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPivotData(): Collection;

    /**
     * Get element's grid CSS class.
     *
     * @return string
     */
    public function gridLayoutClass(): string;

    /**
     * Prepare the instance for snippets display.
     *
     * @param \Illuminate\Support\Collection
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function prepareSnippetsData(Collection $options): Element;

    /**
     * Obtain model viewer to be used for element snippets.
     *
     * @param string $theme
     * @param string|null $view_package
     * @return \Softworx\RocXolid\CMS\Elements\Components\SnippetModelViewer
     */
    public function getSnippetModelViewerComponent(string $theme, ?string $view_package = null): SnippetModelViewer;
}
