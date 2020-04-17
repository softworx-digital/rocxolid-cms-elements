<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Forms\Text;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// fields
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;

/**
 * Create form definition for Text page element.
 *
 * @package Softworx\RocXolid\CMS\Elements
 * @author   Peter Bolemant <peter@softworx.digital>
 * @version  1.0
 * @access   public
 */
class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['content']['type'] = WysiwygTextarea::class;

        return $fields;
    }
}
