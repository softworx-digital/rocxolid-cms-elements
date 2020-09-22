<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid traits
use Softworx\RocXolid\Traits as rxTraits;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid cms elements meta data contracts
use Softworx\RocXolid\CMS\Elements\MetaData\Contracts\MetaDataOperator;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Element's meta data operator abstraction.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractMetaDataOperator implements MetaDataOperator
{
    use rxTraits\Valueable;

    /**
     * @var \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element Parent element.
     */
    protected $element;

    /**
     * @var array $field_definition Form field definition to be used for element's form.
     */
    protected $field_definition;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     */
    public function __construct(Element $element)
    {
logger(__METHOD__);
logger(get_class($element));
logger($element);
        $this->element = $element;
    }

    /**
     * {@inheritDoc}
     */
    public function fill(Collection $data): MetaDataOperator
    {
        if ($data->has($this->getFormFieldName())) {
            $this->element->meta_data = $this->element->meta_data->put($this->provideMetaDataName(), $data->get($this->getFormFieldName()))
                ->filter()
                ->toJson();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function provideMetaDataName(): string
    {
        return (new \ReflectionClass($this))->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function provideMetaDataFieldName(): string
    {
        return Str::snake((new \ReflectionClass($this))->getShortName());
    }

    /**
     * {@inheritDoc}
     */
    public function provideMetaDataFieldsDefinition(AbstractCrudForm $form): array
    {
        return [ $this->getFormFieldName() => $this->setFieldDefinitionValue($form, $this->getFieldDefinition($form)) ];
    }

    /**
     * {@inheritDoc}
     */
    public function preventsElementDisplay(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function adjustRenderedContent(Element $element, string $content, array $assignments = []): string
    {
        return $content;
    }

    /**
     * Obtain form field name to be used for element's form.
     *
     * @return string
     */
    protected function getFormFieldName(): string
    {
        return sprintf('meta_data#%s', $this->provideMetaDataFieldName());
    }

    /**
     * Obtain form field definition to be used for element's form.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @return array
     */
    protected function getFieldDefinition(AbstractCrudForm $form): array
    {
        return $this->field_definition;
    }

    /**
     * Set value to the field definition.
     *
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     * @param array $definition
     * @return array
     */
    protected function setFieldDefinitionValue(AbstractCrudForm $form, array $definition): array
    {
        $definition['options']['value'] = optional($this->element->provideMetaData(true)->get($this->provideMetaDataName(), null))->getValue();

        return $definition;
    }
}
