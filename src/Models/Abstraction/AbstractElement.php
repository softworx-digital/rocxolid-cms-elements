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
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// rocXolid cms model traits traits
use Softworx\RocXolid\CMS\Models\Traits\HasFrontpageUrlAttribute;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

use Softworx\RocXolid\CMS\Elements\Components\SnippetModelViewers\SnippetModelViewer;

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
    use HasWeb;
    use HasFrontpageUrlAttribute;
    //use UserGroupAssociatedWeb;

    protected static $template_dir = 'page-element';

    protected static $snippet_model_viewer_type = SnippetModelViewer::class;

    /**
     * Pivot data holder.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $pivot_data;

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
    abstract public function gridLayoutClass(): string;

    /**
     * {@inheritDoc}
     */
    public function getElementTypeParam(): string
    {
        return Str::kebab((new \ReflectionClass($this))->getShortName());
    }

    /**
     * {@inheritDoc}
     */
    public function setPivotData(Collection $pivot_data): Element
    {
        $this->pivot_data = $pivot_data;

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
    protected function getTableBaseName()
    {
        return Str::plural(Str::snake((new \ReflectionClass($this))->getShortName()));
    }
}
