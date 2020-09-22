<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Paramable;
use Softworx\RocXolid\Contracts\Optionable;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Cloneable;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProviderable;
use Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProviderable;
// rocXolid cms elements model viewer components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\SnippetModelViewer;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\MetaDataProvider;

/**
 * Interface for model to be used as element for an elementable.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface Element extends
    MetaDataProvider,
    ElementsDependenciesProviderable,
    ElementsMutatorsProviderable,
    Paramable,
    Optionable,
    Cloneable
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
    public function getDocumentEditorElementType(): string;

    /**
     * Obtain snippet preview image used in document editor element addition.
     *
     * @return string
     */
    public function getDocumentEditorElementSnippetPreview(): string;

    /**
     * Obtain snippet preview title used in document editor element addition.
     *
     * @return string
     */
    public function getDocumentEditorElementSnippetTitle(): string;

    /**
     * Obtain snippet categories used in document editor element addition.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDocumentEditorElementSnippetCategories(): Collection;

    /**
     * Set structure parent element.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $parent
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function setParent(Elementable $parent): Element;

    /**
     * Get topmost container element.
     *
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function getContainer(): Element;

    /**
     * Set essential element data on element creation.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
     */
    public function setElementData(Collection $data): Element;

    /**
     * Set data from pivot so it can be used on frontpage and elsewhere.
     *
     * @param \Illuminate\Support\Collection $pivot_data
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element
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
     * Obtain element settings URL.
     *
     * @return string|null
     */
    public function getSettingsUrl(): ?string;

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

    /**
     * Check if element content will be empty (when rendered) with given complementary assignments.
     *
     * @param array $assignments
     * @return bool
     */
    public function isEmptyContent(array $assignments = []): bool;

    /**
     * Render element content with given complementary assignments.
     *
     * @param array $assignments
     * @return string
     */
    public function renderContent(array $assignments = []): string;

    /**
     * Obtain available templates for an element.
     *
     * @param string $theme
     * @return \Illuminate\Support\Collection
     */
    public static function getAvailableTemplates(string $theme): Collection;
}
