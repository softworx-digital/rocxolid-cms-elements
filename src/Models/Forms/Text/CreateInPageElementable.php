<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Forms\Text;

use Softworx\RocXolid\CMS\Models\Forms\AbstractCreateInPageElementable;
// fields
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;

/**
 * Create form definition for Text page element used when creating directly in page.
 *
 * @package Softworx\RocXolid\CMS\Elements
 * @author   Peter Bolemant <peter@softworx.digital>
 * @version  1.0
 * @access   public
 */
class CreateInPageElementable extends AbstractCreateInPageElementable
{
    protected function adjustFieldsDefinition($fields)
    {
        $fields['content']['type'] = WysiwygTextarea::class;

        return parent::adjustFieldsDefinition($fields);
    }
}
