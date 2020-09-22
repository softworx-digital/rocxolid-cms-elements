<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Contracts;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

/**
 * Enables meta data to be provided to elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface MetaDataProvider
{
    /**
     * Obtain available meta data that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableMetaData(): Collection;

    /**
     * Obtain element meta data.
     *
     * @param bool $reload
     * @return \Illuminate\Support\Collection
     */
    public function provideMetaData($reload = false): Collection;

    /**
     * Check if element is assigned meta data of specific type.
     *
     * @param string $type
     * @return bool
     */
    public function isMetaData(string $type): bool;

    /**
     * Obtain element meta data in base64 encoded JSON format.
     *
     * @return string|null
     */
    public function getMetaData(): ?string;

    /**
     * Fill element meta data from given data.
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     */
    public function fillMetaData(Collection $data): Crudable;
}