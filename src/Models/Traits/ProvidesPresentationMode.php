<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

// rocXolid cms elements models contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\PresentationModeProvider;

/**
 * Trait for make element aware of its presentation mode.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait ProvidesPresentationMode
{
    /**
     * Presentation mode flag.
     *
     * @var boolean
     */
    protected $is_presentation_mode = false;

    /**
     * {@inheritDoc}
     */
    public function setPresenting(bool $presenting = true): PresentationModeProvider
    {
        $this->is_presentation_mode = $presenting;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isPresenting(): bool
    {
        return $this->is_presentation_mode;
    }
}
