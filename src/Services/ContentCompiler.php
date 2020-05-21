<?php

namespace Softworx\RocXolid\CMS\Elements\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
// rocXolid rendering services
use Softworx\RocXolid\Rendering\Services\RenderingService;
// rocXolid cms elements model contracts
use Softworx\RocXolid\CMS\Elements\Models\Contracts\Element;

/**
 * Element content compiler.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class ContentCompiler
{
    /**
     * Dependencies provider reference.
     *
     * @var \Softworx\RocXolid\CMS\Models\Contracts\ElementsDependenciesProvider
     */
    private $dependencies_provider;

    /**
     * Dependencies data provider reference.
     *
     * @var \Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider
     */
    private $dependencies_data_provider;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     */
    private function __construct(Element $element)
    {
        $this->dependencies_provider = $element->getDependenciesProvider();
        $this->dependencies_data_provider = $element->getDependenciesDataProvider();
    }

    /**
     * Initialization.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Softworx\RocXolid\CMS\Elements\Services\ContentCompiler
     */
    public static function init(Element $element): ContentCompiler
    {
        return new static($element);
    }

    /**
     * Set dependencies data and compile given element content if the dependencies data provider is ready.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @param string $content
     * @param \Illuminate\Support\Collection $assignments
     * @return string
     */
    public function process(string $content, Collection $assignments): string
    {
        if (blank($content) || !$this->dependencies_data_provider->isReady()) {
            return $content;
        }

        $dependencies = $this->dependencies_provider->provideDependencies();

        $dependencies->each(function ($dependency) use ($assignments) {
            $dependency->addAssignment($assignments, $this->dependencies_data_provider);
        });

        $content = $this->compileContent($content, $assignments->all());

        return $content;
    }

    /**
     * Compile the provided content:
     *  replace placeholders with real dependency values
     *  take actions on empty dependency values
     *
     * @param string $content
     * @param array $assignments
     * @return string
     */
    protected function compileContent(string $content, array $assignments): string
    {
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        collect($doc->getElementsByTagName('span'))->each(function($span) use ($doc, $assignments) {
            if ($span->hasAttribute('data-dependency')) {
                $dependency_statement = $this->dependencyStatement($span);
                $dependency_statement_value = RenderingService::render($dependency_statement, $assignments);

                if (blank($dependency_statement_value) && $span->hasAttribute('data-dependency-on-empty')) {

                    $dependency_on_empty_handler = sprintf('onEmptyDependency%s', Str::studly($span->getAttribute('data-dependency-on-empty')));

                    if (!method_exists($this, $dependency_on_empty_handler)) {
                        throw new \RuntimeException(sprintf('Method for dependency handler %s::%s() does not exist', get_class($this), $dependency_on_empty_handler));
                    }

                    $this->{$dependency_on_empty_handler}($span);
                } else {
                    $span->parentNode->replaceChild($doc->createTextNode($dependency_statement_value), $span);
                }
            }
        });

        $content = $doc->saveHTML($doc->documentElement);
        $content = htmlspecialchars_decode($content);

        return $content;
    }

    /**
     * Create blade statement for dependency.
     *
     * @param \DOMNode $span
     * @return string
     */
    protected function dependencyStatement(\DOMNode $span): string
    {
        $dependency_statement = $span->getAttribute('data-dependency');

        $dependency_statement = preg_replace_callback('/::(\w+)/', function($matches) {
            return sprintf('->%s()', $matches[1]);
        }, $dependency_statement);

        $dependency_statement = preg_replace_callback('/:(\w+)/', function($matches) {
            return sprintf('->getAttributeViewValue(\'%s\')', $matches[1]);
        }, $dependency_statement);

        /*
        $dependency_statement = preg_replace_callback('/(\w+)\.(\w+)/', function($matches) {
            return sprintf('optional(%s->%s)', $matches[1], $matches[2]);
        }, $dependency_statement);
        */

        $dependency_statement = preg_replace_callback('/\.(\w+)/', function($matches) {
            return sprintf('->%s', $matches[1]);
        }, $dependency_statement);

        // @todo: hardcoded exceptions
        if (collect([ '{PAGENO}', '{nb}' ])->contains($dependency_statement)) {

        } else {
            // if (Str::startsWith($dependency_statement, 'optional') {}
            $dependency_statement = sprintf('{!! $%s !!}', $dependency_statement);
        }

        return $dependency_statement;
    }

    /**
     * Action to take if empty dependency value - remove parent node.
     *
     * @param \DOMNode $span
     */
    protected function onEmptyDependencyRemoveParent(\DOMNode &$span)
    {
        $span->parentNode->parentNode->removeChild($span->parentNode);
    }
}
