<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData;

// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms elements meta data operators
use Softworx\RocXolid\CMS\Elements\MetaData\AbstractMetaDataOperator;

/**
 * FontAwesome icon attacher.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class FontAwesomeIcon extends AbstractMetaDataOperator
{
    /**
     * {@inheritDoc}
     */
    protected $field_definition = [
        'type' => FieldType\Input::class,
        'options' => [
            'label' => [
                'title' => 'meta_data.font_awesome_icon',
            ],
            'validation' => [
                'rules' => [
                    'nullable',
                    // 'regex:/\d(\.\d)*/',
                ],
            ],
        ],
    ];
}
