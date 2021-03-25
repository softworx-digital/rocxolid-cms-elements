<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Interface for model to be used as final element that cannot contain other elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface ComponentElement extends Element
{
    /**
     * Fill content from request.
     * If the content is separated to parts, store it as JSON.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\ComponentElement
     */
    public function fillContent(Collection $data): ComponentElement;

    /**
     * Retrieve the content (part).
     *
     * @param string|null $part
     * @return string
     */
    public function getContent($part = null): string;

    /**
     * Check if content (part) is set to element.
     *
     * @param string|null $part
     * @return bool
     * @throws \RuntimeException
     */
    public function isSetContent(?string $part = null): bool;

    /**
     * Decide whether to use default value for content (part).
     *
     * @param string|null $part
     * @return bool
     */
    public function useDefaultContent(?string $part = null): bool;

    /**
     * Obtain default element content.
     *
     * @return string
     */
    public function getDefaultContent(?string $part = null): string;
}
