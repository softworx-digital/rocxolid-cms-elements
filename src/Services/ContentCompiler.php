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
     * Mutators provider reference.
     *
     * @var \Softworx\RocXolid\CMS\Models\Contracts\ElementsMutatorsProvider
     */
    private $mutators_provider;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     */
    private function __construct(Element $element)
    {
        $this->dependencies_provider = $element->getDependenciesProvider();
        $this->dependencies_data_provider = $element->getDependenciesDataProvider();
        $this->mutators_provider = $element->getMutatorsProvider();
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

        $this->dependencies_provider
            ->provideDependencies()
            ->each(function ($dependency) use ($assignments) {
                $dependency->addAssignment($assignments, $this->dependencies_data_provider);
            });

        $content = $this->compileContent($content, $assignments->all());

        return $content;
    }

    /**
     * Compile the provided content:
     *  replace placeholders with real dependency values
     *  take actions on empty dependency values
     *  process value mutators
     *
     * @param string $content
     * @param array $assignments
     * @return string
     */
    protected function compileContent(string $content, array $assignments): string
    {
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadHTML(sprintf('<body>%s</body>', $content), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        collect($doc->getElementsByTagName('span'))->each(function($span) use ($doc, $assignments) {
            if ($span->hasAttribute('data-dependency')) {
                $this->handleDependencyStatementNode($doc, $span, $assignments);
            }
        });

        collect($doc->getElementsByTagName('span'))->each(function($span) use ($doc, $assignments) {
            if ($span->hasAttribute('data-mutator')) {
                $this->handleMutatorStatementNode($doc, $span, $assignments);
            }
        });

        $content = $doc->saveHTML($doc->documentElement);
        $content = str_replace([ '<body>', '</body>' ] , '', $content);
        $content = htmlspecialchars_decode($content);

        return $content;
    }

    protected function handleDependencyStatementNode(\DOMDocument &$doc, \DOMElement &$span, $assignments)
    {
        $dependency_statement = $this->makeDependencyStatement($span);
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

    protected function handleMutatorStatementNode(\DOMDocument &$doc, \DOMElement &$span, $assignments)
    {
        if ($mutator = $this->mutators_provider->getMutator($span->getAttribute('data-mutator'))) {
            $mutated = $mutator->mutate($this->dependencies_data_provider, $span->nodeValue);

            $span->parentNode->replaceChild($doc->createTextNode($mutated), $span);
        }
    }

    /**
     * Create blade statement for dependency.
     *
     * @param \DOMElement $span
     * @return string
     */
    protected function makeDependencyStatement(\DOMElement $span): string
    {
        $dependency_statement = $span->getAttribute('data-dependency');

        // @todo: hardcoded exceptions
        if (collect([ '{PAGENO}', '{nb}' ])->contains($dependency_statement)) {
            return $dependency_statement;
        }

        // method calls
        $dependency_statement = preg_replace_callback('/::(\w+)/', function($matches) {
            return sprintf('->%s()', $matches[1]);
        }, $dependency_statement);

        // attributes through \Softworx\RocXolid\Models\Traits\HasAttributes::getAttributeViewValue()
        $dependency_statement = preg_replace_callback('/:(\w+)/', function($matches) {
            return sprintf('->getAttributeViewValue(\'%s\')', $matches[1]);
        }, $dependency_statement);

        // attributes access
        $dependency_statement = preg_replace_callback('/\.(\w+)/', function($matches) {
            return sprintf('->%s', $matches[1]);
        }, $dependency_statement);

        // make it a variable to be interpreted
        $dependency_statement = sprintf('$%s', $dependency_statement);

        // making the chain optional to handle null pointers
        while (preg_match('/(.+->\w+)->(\w+)/', $dependency_statement)) {
            $dependency_statement = preg_replace_callback('/(.+->\w+)->(\w+)/', function($matches) {
                return sprintf('optional(%s)->%s', $matches[1], $matches[2]);
            }, $dependency_statement);
        }

        /*
         * The goal was to compile dependency values & mutators in one iteration
        if (!$this->isMutatorMutatorChild($span)) {
            $dependency_statement = sprintf('{!! %s !!}', $dependency_statement);
        }
        */

        $dependency_statement = sprintf('{!! %s !!}', $dependency_statement);

        return $dependency_statement;
    }

    /**
     * Action to take if empty dependency value - remove parent node.
     *
     * @param \DOMElement $span
     */
    protected function onEmptyDependencyRemoveParent(\DOMElement &$span)
    {
        $span->parentNode->parentNode->removeChild($span->parentNode);
    }

    protected function isMutatorMutatorChild(\DOMElement $span)
    {
        return ($span->parentNode instanceof \DOMElement)
            && ($span->parentNode->nodeName === 'span')
            && ($span->parentNode->hasAttribute('data-mutator'));
    }
}
