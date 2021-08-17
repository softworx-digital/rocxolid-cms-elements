<?php

/**
 *--------------------------------------------------------------------------
 * General CMS Elements configuration.
 *--------------------------------------------------------------------------
 */
return [
    /**
     * View composers.
     */
    'composers' => [
        'rocXolid:cms-elements::*' => Softworx\RocXolid\CMS\Elements\Composers\ViewComposer::class,
    ],
];