<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData\Contracts;

use Illuminate\Support\Collection;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Valueable;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Interface for element's meta data operators.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
interface MetaDataOperator extends Valueable
{
    /**
     * Fill element's meta data with the one handled by the meta data operator.
     *
     * @param \Illuminate\Support\Collection $data
     * @return MetaData
     */
    public function fill(Collection $data): MetaDataOperator;

    /**
     * Obtain meta data operator field name to used in element's own meta data values.
     *
     * @return string
     */
    public function provideMetaDataName(): string;

    /**
     * Obtain meta data operator field name to used in requests.
     *
     * @return string
     */
    public function provideMetaDataFieldName(): string;

    /**
     * Provide meta data fields definition.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @return array
     */
    public function provideMetaDataFieldsDefinition(AbstractCrudForm $form): array;

    /**
     * Consider the element to be displayed when being rendered.
     *
     * @return bool
     */
    public function preventsElementDisplay(): bool;

    /**
     * Adjust the rendered content by element's before final output.
     *
     * @param string $content
     * @param array $assignments
     * @return string
     */
    public function adjustRenderedContent(Element $element, string $content, array $assignments = []): string;
}
