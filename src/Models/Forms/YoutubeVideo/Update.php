<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Forms\YoutubeVideo;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 *
 */
class Update extends AbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'modal-footer-template' => 'reload',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
        'url' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'url',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'url',
                        'regex:/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&"\'>]+)/',
                        'max:255',
                    ],
                ],
            ],
        ],
        'content' => [
            // 'type' => FieldType\WysiwygTextarea::class,
            'type' => FieldType\Textarea::class,
            'options' => [
                'label' => [
                    'title' => 'content',
                ],
                'validation' => [
                    'rules' => [
                        'max:10000',
                    ],
                ],
            ],
        ],
    ];
}
