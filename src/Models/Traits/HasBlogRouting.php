<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Str;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Localization;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\Page;
use Softworx\RocXolid\CMS\Models\Article;
use Softworx\RocXolid\CMS\Models\ArticleCategory;

/**
 * @todo revise & generalize
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
        if (blank(config('rocXolid.cms.dependency.semantics.article'))) {
            throw new \RuntimeException(sprintf(
                'Unspecified dependency for "%s" identification, configure in [rocXolid.cms.dependency.semantics.%s]',
                'article',
                'article'
            ));
        }

        return Page::where('is_enabled', true)
            ->where('localization_id', $localization->getKey())
            ->whereJsonContains('dependencies', config('rocXolid.cms.dependency.semantics.article'))->first();
    }

    private function articleCategoryPage(Localization $localization): ?Page
    {
        if (blank(config('rocXolid.cms.dependency.semantics.article-category'))) {
            throw new \RuntimeException(sprintf(
                'Unspecified dependency for "%s" identification, configure in [rocXolid.cms.dependency.semantics.%s]',
                'article-category',
                'article-category'
            ));
        }

        return Page::where('is_enabled', true)
            ->where('localization_id', $localization->getKey())
            ->whereJsonContains('dependencies', config('rocXolid.cms.dependency.semantics.article-category'))->first();
    }

    private function articleTagPage(Localization $localization): ?Page
    {
        if (blank(config('rocXolid.cms.dependency.semantics.article'))) {
            throw new \RuntimeException(sprintf(
                'Unspecified dependency for "%s" identification, configure in [rocXolid.cms.dependency.semantics.%s]',
                'article-tag',
                'article-tag'
            ));
        }

        return Page::where('is_enabled', true)
            ->where('localization_id', $localization->getKey())
            ->whereJsonContains('dependencies', config('rocXolid.cms.dependency.semantics.article-tag'))->first();
    }
}
