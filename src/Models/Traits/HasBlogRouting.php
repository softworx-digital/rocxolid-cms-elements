<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Str;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\Article;
use Softworx\RocXolid\CMS\Models\ArticleCategory;
// rocXolid cms element dependencies
use Softworx\RocXolid\CMS\ElementableDependencies\Page\Article as ArticleDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Page\ArticleCategory as ArticleCategoryDependency;
use Softworx\RocXolid\CMS\ElementableDependencies\Page\ArticleTag as ArticleTagDependency;

/**
 * @todo revise
 */
trait HasBlogRouting
{
    public function articleRoute(Localization $localization, Article $article): string
    {
        if ($article->exists && ($page = $this->articleDetailPage($localization))) {
            return sprintf('/%s/%s/%s', $page->path, $article->getKey(), $article->slug);
        }

        return '#';
    }

    public function articleCategoryRoute(Localization $localization, ArticleCategory $article_category): string
    {
        if ($article_category->exists && ($page = $this->articleCategoryPage($localization))) {
            return sprintf('/%s/%s/%s', $page->path, $article_category->getKey(), $article_category->slug);
        }

        return '#';
    }

    public function articleTagRoute(Localization $localization, string $tag): string
    {
        if ($page = $this->articleTagPage($localization)) {
            return sprintf('/%s/%s', $page->path, Str::slug($tag));
        }

        return '#';
    }

    private function articleDetailPage(Localization $localization): ?Page
    {
        return Page::where('is_enabled', true)
            ->where('localization_id', $localization->getKey())
            ->whereJsonContains('dependencies', ArticleDependency::class)->first();
    }

    private function articleCategoryPage(Localization $localization): ?Page
    {
        return Page::where('is_enabled', true)
            ->where('localization_id', $localization->getKey())
            ->whereJsonContains('dependencies', ArticleCategoryDependency::class)->first();
    }

    private function articleTagPage(Localization $localization): ?Page
    {
        return Page::where('is_enabled', true)
            ->where('localization_id', $localization->getKey())
            ->whereJsonContains('dependencies', ArticleTagDependency::class)->first();
    }
}
