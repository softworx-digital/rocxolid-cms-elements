<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Forms\AbstractElement;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms elements meta data contracts
use Softworx\RocXolid\CMS\Elements\MetaData\Contracts\MetaDataOperator;

/**
 *
 */
abstract class AbstractUpdate extends RocXolidAbstractCrudForm
{
    /**
     * @inheritDoc
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'show-back-button' => false,
    ];

    /**
     * @inheritDoc
     */
    protected $fields = [];

    /**
     * @inheritDoc
     */
    protected $buttons = [
        'submit' => [
            'type' => FieldType\ButtonSubmit::class,
            'options' => [
                'label' => [
                    'title' => 'save',
                ],
                'attributes' => [
                    'class' => 'btn btn-primary col-xs-12'
                ],
            ],
        ],
    ];

    /**
     * @inheritDoc
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = []; // to clear fields added by default (model's fillable)

        $this->getModel()->getAvailableMetaData()->each(function (MetaDataOperator $meta_data_operator) use (&$fields) {
            $fields += $meta_data_operator->provideMetaDataFieldsDefinition($this);
        });

        return $fields;
    }
}
