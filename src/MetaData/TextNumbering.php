<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid cms elements meta data operators
use Softworx\RocXolid\CMS\Elements\MetaData\AbstractMetaDataOperator;
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;
use Softworx\RocXolid\CMS\Elements\Models\Text;

/**
 * Text numbering element's meta data operator.
 * Text numbering serves to define container number and assign order numbers for underlying displayed text elements.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
class TextNumbering extends AbstractMetaDataOperator
{
    /**
     * Block elements - the numbering should be contained in them.
     *
     * @var array
     */
    private const BLOCK_ELEMENTS = [
        'div',
    ];

    private $counter = 1;

    /**
     * {@inheritDoc}
     */
    protected $field_definition = [
        'type' => FieldType\Input::class,
        'options' => [
            'label' => [
                'title' => 'meta_data.text_numbering',
            ],
            'validation' => [
                'rules' => [
                    'nullable',
                    'regex:/\d(\.\d)*/',
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function adjustRenderedContent(Element $element, string $content, array $assignments = []): string
    {
        if ($element instanceof Text) {
            if (filled(strip_tags($content))) {
                return $this->addNumbering($content);
            } else {
                return '';
            }
        }

        return $content;
    }

    private function addNumbering($content)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadHTML(sprintf('<body>%s</body>', mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8')), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        collect($doc->getElementsByTagName('div'))->each(function (\DOMElement $div) {
            if ($div->hasAttribute('data-element-type')) {
                $numbering = new \DOMElement('span', sprintf('%s.%s ', $this->getValue(), $this->counter));
                $inserted = false;

                collect($div->childNodes)->each(function (\DOMNode $node) use ($numbering, &$inserted) {
                    if (collect(self::BLOCK_ELEMENTS)->contains($node->nodeName)) {
                        $node->insertBefore($numbering, $node->firstChild);
                        $inserted = true;
                    }
                });

                if (!$inserted) {
                    $div->insertBefore($numbering, $div->firstChild);
                }
            }
        });

        $content = $doc->saveHTML($doc->documentElement);
        $content = str_replace([ '<body>', '</body>' ], '', $content);
        $content = htmlspecialchars_decode($content);

        $this->counter++;

        return $content;
    }
}
