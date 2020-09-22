<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\DisplayRulesProvider;
// rocXolid cms elements meta data operators
use Softworx\RocXolid\CMS\Elements\MetaData\AbstractMetaDataOperator;
// rocXolid cms elements meta data display rules contracts
use Softworx\RocXolid\CMS\Elements\MetaData\DisplayRules\Contracts\DisplayRule;

/**
 * Display rules element's meta data operator.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class DisplayRules extends AbstractMetaDataOperator
{
    /**
     * {@inheritDoc}
     */
    protected $field_definition = [
        'type' => FieldType\CollectionSelect::class,
        'options' => [
            'label' => [
                'title' => 'meta_data.display_rules',
            ],
            'placeholder' => [
                'title' => 'none',
            ],
            'validation' => [
                'rules' => [
                    'nullable',
                    'class_exists',
                ],
            ],
        ],
    ];

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\DisplayRulesProvider $element
     */
    public function __construct(DisplayRulesProvider $element)
    {
        $this->element = $element;
    }

    /**
     * {@inheritDoc}
     */
    public function preventsElementDisplay(): bool
    {
        return !collect($this->getValue())->reduce(function (bool $carrier, string $display_rule_type) {
            return $carrier || app($display_rule_type)->preventsElementDisplay($this->element->getDependenciesDataProvider());
        }, false);
    }

    /**
     * {@inheritDoc}
     */
    protected function getFieldDefinition(AbstractCrudForm $form): array
    {
        $definition = $this->field_definition;

        $definition['options']['collection'] = $this->element->getAvailableDisplayRules()->map(function (DisplayRule $rule) use ($form) {
            return [
                (new \ReflectionClass($rule))->getName(),
                $rule->getTranslatedTitle($form->getController()),
            ];
        })->toAssoc();

        return $definition;
    }
}
