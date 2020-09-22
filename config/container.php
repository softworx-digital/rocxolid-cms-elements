<?php

/**
 *--------------------------------------------------------------------------
 * Elements display configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * List of available meta data for given elements.
     */
    'available-meta-data' => [
        // fallback if target element is not listed
        'default' => [
        ],
        // grid row - topmost container
        \Softworx\RocXolid\CMS\Elements\Models\GridRow::class => [
        ],
        // grid column - inner container
        \Softworx\RocXolid\CMS\Elements\Models\GridColumn::class => [
        ],
    ],
];