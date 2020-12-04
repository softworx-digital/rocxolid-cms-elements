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
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid model viewer components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid cms facades
use Softworx\RocXolid\CMS\Facades\ThemeManager;
// rocXolid cms model traits
use Softworx\RocXolid\CMS\Models\Traits as CMSTraits;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
// rocXolid cms elements model traits
use Softworx\RocXolid\CMS\Elements\Models\Traits as Traits;
// rocXolid cms elements model viewer components
use Softworx\RocXolid\CMS\Elements\Components\ModelViewers\SnippetModelViewer;

/**
 * Abstraction for element models.
 * Elements can be assigned to an elementable (eg. page or document).
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 * @todo: use \Softworx\RocXolid\Models\Traits\Utils\Configurable trait
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
    use Traits\HasMetaData;

    /**
     * @var string $snippet_model_viewer_type Model viewer type used for snippet rendering.
     */
    protected static $snippet_model_viewer_type = SnippetModelViewer::class;

    /**
     * @var \Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable $parent Element structure parent reference.
     */
    protected $parent;

    /**
     * @var \Illuminate\Support\Collection $pivot_data Pivot data holder.
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
    protected $fillable = [
        'meta_data',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'web',
    ];

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorElementType(): string;

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorElementSnippetPreview(): string;

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorElementSnippetTitle(): string;

    /**
     * {@inheritDoc}
     */
    abstract public function getDocumentEditorElementSnippetCategories(): Collection;

    /**
     * {@inheritDoc}
     */
    abstract public function gridLayoutClass(): string;

    /**
     * {@inheritDoc}
     */
    public function getSettingsUrl(): ?string
    {
        $user = auth('rocXolid')->user();

        if ($this->exists && $this->getAvailableMetaData()->isNotEmpty() && $user->can('update', $this)) {
            return $this->getControllerRoute('edit');
        } elseif (!$this->exists && $this->getAvailableMetaData()->isNotEmpty() && $user->can('create', $this)) {
            // return $this->getControllerRoute('create');
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setParent(Elementable $parent): Element
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer(): Element
    {
        return $this->parent->getContainer();
    }

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this->fillMetaData($data);

        return parent::fillCustom($data);
    }

    /**
     * {@inheritDoc}
     */
    public function setElementData(Collection $data): Element
    {
        $this->fillCustom($data);

        return $this;
    }

    /**
     * Option setting handler.
     * Set element snippet group.
     *
     * @param string $group
     */
    public function setGroup(string $group): Element
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
    public function setTemplate(string $template): Element
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
    public function renderContent(array $assignments = []): string
    {
        if (!$this->isDisplayed($assignments)) {
            return '';
        }

        $content = $this->getModelViewerComponent()->render($this->getPivotData()->get('template'), $assignments);

        return $this->adjustRenderedContent($content, $assignments);
    }

    /**
     * {@inheritDoc}
     */
    public function isEmptyContent(array $assignments = []): bool
    {
        return blank(strip_tags($this->renderContent($assignments)));
    }

    /**
     * {@inheritDoc}
     */
    public static function getAvailableTemplates(string $theme): Collection
    {
        return ThemeManager::getComponentTemplates($theme, (new static())->getModelViewerComponent());
    }

    /**
     * Check if the element is to be displayed when being rendered.
     *
     * @param array $assignments
     * @return boolean
     */
    protected function isDisplayed(array $assignments = [])
    {
        return !$this->getDependenciesDataProvider()->isReady() || $this->isDisplayedByMetaData();
    }

    /**
     * Adjust the rendered content before final output.
     *
     * @param string $content
     * @param array $assignments
     * @return string
     */
    protected function adjustRenderedContent(string $content, array $assignments = []): string
    {
        return !$this->getDependenciesDataProvider()->isReady()
            ? $content
            : $this->adjustRenderedContentByMetaData($content, $assignments);
    }

    /**
     * Obtain asset URL to snippet preview image.
     *
     * @param string $image
     * @return string
     */
    protected function getDocumentEditorElementSnippetPreviewAssetPath(string $image): string
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

    /**
     * Obtain model specific (fallbacks to 'default') configuration.
     *
     * @param string $key
     * @return \Illuminate\Support\Collection
     */
    protected static function getConfigData(string $key): Collection
    {
        $config = static::getConfigFilePathKey();

        return collect(config(sprintf('%s.%s.%s', $config, $key, static::class), config(sprintf('%s.%s.default', $config, $key), [])));
    }

    /**
     * Obtain config file path key.
     *
     * @return string
     */
    abstract protected static function getConfigFilePathKey(): string;
}
