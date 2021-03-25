<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

// rocXolid model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Enables models to have presentation mode awareness.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface PresentationModeProvider
{
    /**
     * Set presentation mode.
     *
     * @param bool $presenting
     * @return \Softworx\RocXolid\CMS\Elements\Models\Contracts\PresentationModeProvider
     */
    public function setPresenting(bool $presenting = true): PresentationModeProvider;

    /**
     * Check if in presentation mode.
     *
     * @return bool
     */
    public function isPresenting(): bool;
}
