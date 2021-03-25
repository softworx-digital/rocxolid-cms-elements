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
        // basic text block
        \Softworx\RocXolid\CMS\Elements\Models\Text::class => [
        ],
    ],
];