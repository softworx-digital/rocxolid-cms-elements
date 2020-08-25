<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid traits
use Softworx\RocXolid\Traits\Paramable;
use Softworx\RocXolid\Traits\MethodOptionable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\Cloneable;
// rocXolid model viewer components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms facades
use Softworx\RocXolid\CMS\Facades\ThemeManager;
// rocXolid cms model traits
use Softworx\RocXolid\CMS\Models\Traits as CMSTraits;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms elements model viewer components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\SnippetModelViewer;

/**
 * Abstraction for element models.
 * Elements can be assigned to a elementable document (eg. page).
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractElement extends AbstractCrudModel implements Element
{
    use SoftDeletes;
    use Paramable;
    use MethodOptionable;
    use Cloneable;
    use CommonTraits\HasWeb;
    //use CommonTraits\UserGroupAssociatedWeb;
    use CMSTraits\HasFrontpageUrlAttribute;
    use CMSTraits\HasElementsDependenciesProvider;
    use CMSTraits\HasElementsMutatorsProvider;
    use CMSTraits\HasElementableDependencyDataProvider;

    /**
     * Model viewer type used for snippet rendering.
     *
     * @var string
     */
    protected static $snippet_model_viewer_type = SnippetModelViewer::class;

    /**
     * Pivot data holder.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $pivot_data;

    /**
     * Snippet group reference.
     *
     * @var string
     */
    protected $group;

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
    ];

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorComponentType(): string;

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorComponentSnippetPreview(): string;

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorComponentSnippetTitle(): string;

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorComponentSnippetCategories(): Collection;

    /**
     * {@inheritDoc}
     */
    abstract public function gridLayoutClass(): string;

    /**
     * {@inheritDoc}
     */
    public function getMetaData(): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmptyContent(array $assignments = []): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function renderContent(array $assignments = []): string
    {
        return $this->getModelViewerComponent()->render($this->getPivotData()->get('template'), $assignments);
    }

    /**
     * Option setting handler.
     * Set element snippet group.
     *
     * @param string $group
     */
    public function setGroup(string $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Option setting handler.
     * Set element snippet template.
     *
     * @param string $template
     */
    public function setTemplate(string $template)
    {
        $this->setPivotData(collect([
            'template' => $template
        ]));

        return $this;
    }

    /**
     * Element theme template name getter.
     *
     * @param string $template
     */
    public function getTemplate(): string
    {
        return optional($this->pivot_data)->get('template') ?? 'default';
    }

    /**
     * Check if element belongs to specified group.
     *
     * @param string $group
     * @return bool
     */
    public function belongsToGroup(string $group): bool
    {
        return $this->group == $group;
    }

    /**
     * {@inheritDoc}
     */
    public function getElementTypeParam(): string
    {
        return $this->getModelName();
    }

    /**
     * {@inheritDoc}
     */
    public function setPivotData(Collection $pivot_data): Element
    {
        $this->pivot_data = collect($this->pivot_data)->merge($pivot_data);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPivotData(): Collection
    {
        return collect($this->pivot_data);
    }

    /**
     * {@inheritDoc}
     */
    public function prepareSnippetsData(Collection $options): Element
    {
        return $this->setOptions($options->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function getModelViewerComponent(?string $view_package = null): CrudModelViewer
    {
        $model_viewer = parent::getModelViewerComponent($view_package);
        $model_viewer->setViewTheme($this->getDependenciesProvider()->provideViewTheme());

        return $model_viewer;
    }

    /**
     * {@inheritDoc}
     */
    public function getSnippetModelViewerComponent(string $theme, ?string $view_package = null): SnippetModelViewer
    {
        $model_viewer = $this->getCrudController()->getModelViewerComponent($this);
        $model_viewer->setViewTheme($theme);

        $snippet_model_viewer = static::$snippet_model_viewer_type::build($this->getCrudController(), $this->getCrudController())
            ->setWrappedComponent($model_viewer);

        if (!is_null($view_package)) {
            $model_viewer->setViewPackage($view_package);
        }

        return $snippet_model_viewer;
    }

    /**
     * {@inheritDoc}
     */
    public static function getAvailableTemplates(string $theme): Collection
    {
        return ThemeManager::getComponentTemplates($theme, (new static())->getModelViewerComponent());
    }

    /**
     * Obtain asset URL to snippet preview image.
     *
     * @param string $image
     * @return string
     */
    protected function getDocumentEditorComponentSnippetPreviewAssetPath(string $image): string
    {
        return asset(sprintf('vendor/softworx/rocXolid-cms-elements/images/snippets/preview/%s.svg', $image));
    }

    /**
     * Obtain table base name to be prefixed further.
     * Pluralize the model's short name.
     *
     * @return string
     */
    protected function getTableBaseName(): string
    {
        return Str::plural(Str::snake((new \ReflectionClass($this))->getShortName()));
    }
}
