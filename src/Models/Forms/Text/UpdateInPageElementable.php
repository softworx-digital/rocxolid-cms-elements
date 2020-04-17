<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Forms\Text;

use Softworx\RocXolid\CMS\Models\Forms\AbstractUpdateInPageElementable;
// fields
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
use Softworx\RocXolid\Forms\Fields\Type\UploadImage;
use Softworx\RocXolid\Forms\Fields\Type\UploadFile;

/**
 * Update form definition for Text page element used when creating directly in page.
 *
 * @package Softworx\RocXolid\CMS\Elements
 * @author   Peter Bolemant <peter@softworx.digital>
 * @version  1.0
 * @access   public
 */
class UpdateInPageElementable extends AbstractUpdateInPageElementable
{
    protected function adjustFieldsDefinition($fields)
    {
        /*
        $fields['image']['type'] = UploadImage::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';

        $fields['file']['type'] = UploadFile::class;
        $fields['file']['options']['multiple'] = false;
        $fields['file']['options']['label']['title'] = 'file';
        */

        $fields['content']['type'] = WysiwygTextarea::class;

        return parent::adjustFieldsDefinition($fields);
    }
}
