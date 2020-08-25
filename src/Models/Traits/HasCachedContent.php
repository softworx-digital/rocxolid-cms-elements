<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Str;

/**
 * Enables CMS element models to cache its compiled content.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait HasCachedContent
{
    /**
     * Block elements - the numbering should be contained in them.
     *
     * @var array
     */
    protected $block_elements = [
        'div',
    ];

    /**
     * In-memory content that was already compiled.
     *
     * @var string
     */
    private $cached_content;

    /**
     * {@inheritDoc}
     */
    public function getCompiledContent(array &$assignments, $recompile = false): string
    {
        if ($recompile || is_null($this->cached_content)) {
            $this->cached_content = $this->getModelViewerComponent()->render($this->getPivotData()->get('template'), $assignments);
        }

        // @todo: ugly & doesn't quite belong here (violates single responsibility principle)
        if ($this->getDependenciesDataProvider()->isReady()
            && isset($assignments['container'])
            && isset($assignments['loop'])
            && isset($assignments['texts'])) {

            $meta_data = collect(json_decode($assignments['container']->getMetaData()));

            if ($text_numbering = $meta_data->get('text-numbering')) {
                $doc = new \DOMDocument('1.0', 'utf-8');
                $doc->loadHTML(sprintf('<body>%s</body>', mb_convert_encoding($this->cached_content, 'HTML-ENTITIES', 'UTF-8')), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                collect($doc->getElementsByTagName('div'))->each(function (\DOMElement $div) use ($doc, $text_numbering, $assignments) {
                    if ($div->hasAttribute('data-element-type')) {
                        // $numbering = new \DOMElement('span', sprintf('%s.%s ', $text_numbering, $assignments['loop']->iteration));
                        $numbering = new \DOMElement('span', sprintf('%s.%s ', $text_numbering, $assignments['texts']));
                        $inserted = false;

                        collect($div->childNodes)->each(function(\DOMNode $node) use ($numbering, &$inserted) {
                            if (collect($this->block_elements)->contains($node->nodeName)) {
                                $node->insertBefore($numbering, $node->firstChild);
                                $inserted = true;
                            }
                        });

                        if (!$inserted) {
                            $div->insertBefore($numbering, $div->firstChild);
                        }
                    }
                });

                $this->cached_content = $doc->saveHTML($doc->documentElement);
                $this->cached_content = str_replace([ '<body>', '</body>' ] , '', $this->cached_content);
                $this->cached_content = htmlspecialchars_decode($this->cached_content);
            }
        }

        return $this->cached_content;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmptyCompiledContent(array $assignments): bool
    {
        return blank(strip_tags($this->getCompiledContent($assignments)));
    }
}
