<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Abstraction;

use File;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid contracts
use Softworx\RocXolid\Traits\Paramable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\Cloneable;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits\HasWeb;
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociatedWeb;
// rocXolid cms model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Elementable;
// rocXolid cms model traits traits
use Softworx\RocXolid\CMS\Models\Traits\HasFrontpageUrlAttribute;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

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
    use Cloneable;
    use HasWeb;
    use HasFrontpageUrlAttribute;
    //use UserGroupAssociatedWeb;

    protected static $template_dir = 'page-element';

    protected $pivot_data = null;

    protected $relationships = [
        'web',
    ];

    abstract public function setDataOnCreate(Collection $data): Element;

    abstract public function getDocumentEditorComponentType(): string;

    protected function getTableBaseName()
    {
        return Str::plural(Str::snake((new \ReflectionClass($this))->getShortName()));
    }

    public function getElementTypeParam(): string
    {
        return Str::kebab((new \ReflectionClass($this))->getShortName());
    }

    public function setPivotData(Collection $pivot_data): Element
    {
        $this->pivot_data = $pivot_data;

        return $this;
    }

    public function getPivotData(): Collection
    {
        return collect($this->pivot_data);
    }









    /*
    protected $pivot_data = null;

    protected $parent_page_elementable = null;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->pages->each(function ($page_elementable) use ($model) {
                $page_elementable->detachPageElement($model);
            });

            $model->pageProxies->each(function ($page_elementable) use ($model) {
                $page_elementable->detachPageElement($model);
            });

            $model->pageTemplates->each(function ($page_elementable) use ($model) {
                $page_elementable->detachPageElement($model);
            });
        });
    }

    public function handleFrontpageRequest($request, Web $web)
    {
        return $this;
    }

    public function getTemplateName($subdirectory = null, $use_template = null, $default_template = 'default')
    {
        if (!is_null($use_template)) {
            $template = $use_template;
        } elseif (property_exists($this, 'template_name')) {
            $template = static::$template_name;
        } elseif (isset($this->template)) {
            $template = $this->template;
        } elseif (isset($this->pivot_data) && isset($this->pivot_data->template)) {
            $template = $this->pivot_data->template;
        } else {
            $template = $default_template;
        }

        if (!is_null($subdirectory)) {
            return sprintf('%s.%s.%s.%s', static::$template_dir, $this->getModelName(), $subdirectory, $template);
        }

        return sprintf('%s.%s.%s', static::$template_dir, $this->getModelName(), $template);
    }

    public function getTemplateOptions(Web $web = null)
    {
        $templates = collect();

        if (is_null($web)) {
            $web = $this->web()->exists() ? $this->web : null;
        }

        if ($web) {
            $views = config('view.paths');
            $path = reset($views);
            $path = sprintf('%s/%s', dirname($path), 'template-sets');
            $path = sprintf('%s/%s/%s/%s/*.blade.php', $path, $web->frontpageSettings->template_set, static::$template_dir, $this->getModelName());

            collect(File::glob($path))->each(function ($file_path, $key) use ($templates) {
                $pathinfo = pathinfo($file_path);
                $template = str_replace('.blade', '', $pathinfo['filename']);

                $templates->put($template, $template);
            });
        }

        return $templates;
    }

    /**
     * {@inheritDoc}
     *//*
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        if ($data->has('_page_template_id')) {
            $page_elementable = PageTemplate::findOrFail($data->get('_page_template_id'));
        } elseif ($data->has('_page_proxy_id')) {
            $page_elementable = PageProxy::findOrFail($data->get('_page_proxy_id'));
        } elseif ($data->has('_page_id')) {
            $page_elementable = Page::findOrFail($data->get('_page_id'));
        } elseif ($data->has('_article_id')) {
            $page_elementable = Article::findOrFail($data->get('_article_id'));
        }

        if (!isset($page_elementable)) {
            throw new \InvalidArgumentException(sprintf('Undefined _page_template_id or _page_proxy_id or _page_id or _article_id'));
        }

        $this->web()->associate($page_elementable->web);

        return parent::onCreateBeforeSave($data);
    }

    public function cloneContaineeRelations($original_page_elementable, $page_elementable)
    {
        return $this;
    }

    public function setParentPageElementable(Elementable $page_elementable)
    {
        $this->parent_page_elementable = $page_elementable;

        return $this;
    }

    public function getParentPageElementable()
    {
        return $this->parent_page_elementable;
    }



    public function pages()
    {
        return $this->morphToMany(Page::class, 'page_element', Page::make()->getPageElementsPivotTable())->withPivot(Page::make()->getPivotExtra());
    }

    public function pageProxies()
    {
        return $this->morphToMany(PageProxy::class, 'page_element', PageProxy::make()->getPageElementsPivotTable())->withPivot(PageProxy::make()->getPivotExtra());
    }

    public function pageTemplates()
    {
        return $this->morphToMany(PageTemplate::class, 'page_element', PageTemplate::make()->getPageElementsPivotTable())->withPivot(PageTemplate::make()->getPivotExtra());
    }
    */
}
