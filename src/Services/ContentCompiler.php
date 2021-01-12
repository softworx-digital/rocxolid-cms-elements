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
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 * @todo optimize
 */
class ContentCompiler
{
    const XML_HTML_DEFS = <<<ENTITIES
<!ENTITY amp "&#38;">
<!ENTITY lt "&#60;">
<!ENTITY gt "&#62;">
<!ENTITY Agrave "&#192;">
<!ENTITY Aacute "&#193;">
<!ENTITY Acirc "&#194;">
<!ENTITY Atilde "&#195;">
<!ENTITY Auml "&#196;">
<!ENTITY Aring "&#197;">
<!ENTITY AElig "&#198;">
<!ENTITY Ccedil "&#199;">
<!ENTITY Egrave "&#200;">
<!ENTITY Eacute "&#201;">
<!ENTITY Ecirc "&#202;">
<!ENTITY Euml "&#203;">
<!ENTITY Igrave "&#204;">
<!ENTITY Iacute "&#205;">
<!ENTITY Icirc "&#206;">
<!ENTITY Iuml "&#207;">
<!ENTITY ETH "&#208;">
<!ENTITY Ntilde "&#209;">
<!ENTITY Ograve "&#210;">
<!ENTITY Oacute "&#211;">
<!ENTITY Ocirc "&#212;">
<!ENTITY Otilde "&#213;">
<!ENTITY Ouml "&#214;">
<!ENTITY Oslash "&#216;">
<!ENTITY Ugrave "&#217;">
<!ENTITY Uacute "&#218;">
<!ENTITY Ucirc "&#219;">
<!ENTITY Uuml "&#220;">
<!ENTITY Yacute "&#221;">
<!ENTITY THORN "&#222;">
<!ENTITY szlig "&#223;">
<!ENTITY agrave "&#224;">
<!ENTITY aacute "&#225;">
<!ENTITY acirc "&#226;">
<!ENTITY atilde "&#227;">
<!ENTITY auml "&#228;">
<!ENTITY aring "&#229;">
<!ENTITY aelig "&#230;">
<!ENTITY ccedil "&#231;">
<!ENTITY egrave "&#232;">
<!ENTITY eacute "&#233;">
<!ENTITY ecirc "&#234;">
<!ENTITY euml "&#235;">
<!ENTITY igrave "&#236;">
<!ENTITY iacute "&#237;">
<!ENTITY icirc "&#238;">
<!ENTITY iuml "&#239;">
<!ENTITY eth "&#240;">
<!ENTITY ntilde "&#241;">
<!ENTITY ograve "&#242;">
<!ENTITY oacute "&#243;">
<!ENTITY ocirc "&#244;">
<!ENTITY otilde "&#245;">
<!ENTITY ouml "&#246;">
<!ENTITY oslash "&#248;">
<!ENTITY ugrave "&#249;">
<!ENTITY uacute "&#250;">
<!ENTITY ucirc "&#251;">
<!ENTITY uuml "&#252;">
<!ENTITY yacute "&#253;">
<!ENTITY thorn "&#254;">
<!ENTITY yuml "&#255;">
<!ENTITY nbsp "&#160;">
<!ENTITY iexcl "&#161;">
<!ENTITY cent "&#162;">
<!ENTITY pound "&#163;">
<!ENTITY curren "&#164;">
<!ENTITY yen "&#165;">
<!ENTITY brvbar "&#166;">
<!ENTITY sect "&#167;">
<!ENTITY uml "&#168;">
<!ENTITY copy "&#169;">
<!ENTITY ordf "&#170;">
<!ENTITY laquo "&#171;">
<!ENTITY not "&#172;">
<!ENTITY shy "&#173;">
<!ENTITY reg "&#174;">
<!ENTITY macr "&#175;">
<!ENTITY deg "&#176;">
<!ENTITY plusmn "&#177;">
<!ENTITY sup2 "&#178;">
<!ENTITY sup3 "&#179;">
<!ENTITY acute "&#180;">
<!ENTITY micro "&#181;">
<!ENTITY para "&#182;">
<!ENTITY cedil "&#184;">
<!ENTITY sup1 "&#185;">
<!ENTITY ordm "&#186;">
<!ENTITY raquo "&#187;">
<!ENTITY frac14 "&#188;">
<!ENTITY frac12 "&#189;">
<!ENTITY frac34 "&#190;">
<!ENTITY iquest "&#191;">
<!ENTITY times "&#215;">
<!ENTITY divide "&#247;">
<!ENTITY forall "&#8704;">
<!ENTITY part "&#8706;">
<!ENTITY exist "&#8707;">
<!ENTITY empty "&#8709;">
<!ENTITY nabla "&#8711;">
<!ENTITY isin "&#8712;">
<!ENTITY notin "&#8713;">
<!ENTITY ni "&#8715;">
<!ENTITY prod "&#8719;">
<!ENTITY sum "&#8721;">
<!ENTITY minus "&#8722;">
<!ENTITY lowast "&#8727;">
<!ENTITY radic "&#8730;">
<!ENTITY prop "&#8733;">
<!ENTITY infin "&#8734;">
<!ENTITY ang "&#8736;">
<!ENTITY and "&#8743;">
<!ENTITY or "&#8744;">
<!ENTITY cap "&#8745;">
<!ENTITY cup "&#8746;">
<!ENTITY int "&#8747;">
<!ENTITY there4 "&#8756;">
<!ENTITY sim "&#8764;">
<!ENTITY cong "&#8773;">
<!ENTITY asymp "&#8776;">
<!ENTITY ne "&#8800;">
<!ENTITY equiv "&#8801;">
<!ENTITY le "&#8804;">
<!ENTITY ge "&#8805;">
<!ENTITY sub "&#8834;">
<!ENTITY sup "&#8835;">
<!ENTITY nsub "&#8836;">
<!ENTITY sube "&#8838;">
<!ENTITY supe "&#8839;">
<!ENTITY oplus "&#8853;">
<!ENTITY otimes "&#8855;">
<!ENTITY perp "&#8869;">
<!ENTITY sdot "&#8901;">
<!ENTITY Alpha "&#913;">
<!ENTITY Beta "&#914;">
<!ENTITY Gamma "&#915;">
<!ENTITY Delta "&#916;">
<!ENTITY Epsilon "&#917;">
<!ENTITY Zeta "&#918;">
<!ENTITY Eta "&#919;">
<!ENTITY Theta "&#920;">
<!ENTITY Iota "&#921;">
<!ENTITY Kappa "&#922;">
<!ENTITY Lambda "&#923;">
<!ENTITY Mu "&#924;">
<!ENTITY Nu "&#925;">
<!ENTITY Xi "&#926;">
<!ENTITY Omicron "&#927;">
<!ENTITY Pi "&#928;">
<!ENTITY Rho "&#929;">
<!ENTITY Sigma "&#931;">
<!ENTITY Tau "&#932;">
<!ENTITY Upsilon "&#933;">
<!ENTITY Phi "&#934;">
<!ENTITY Chi "&#935;">
<!ENTITY Psi "&#936;">
<!ENTITY Omega "&#937;">
<!ENTITY alpha "&#945;">
<!ENTITY beta "&#946;">
<!ENTITY gamma "&#947;">
<!ENTITY delta "&#948;">
<!ENTITY epsilon "&#949;">
<!ENTITY zeta "&#950;">
<!ENTITY eta "&#951;">
<!ENTITY theta "&#952;">
<!ENTITY iota "&#953;">
<!ENTITY kappa "&#954;">
<!ENTITY lambda "&#955;">
<!ENTITY mu "&#956;">
<!ENTITY nu "&#957;">
<!ENTITY xi "&#958;">
<!ENTITY omicron "&#959;">
<!ENTITY pi "&#960;">
<!ENTITY rho "&#961;">
<!ENTITY sigmaf "&#962;">
<!ENTITY sigma "&#963;">
<!ENTITY tau "&#964;">
<!ENTITY upsilon "&#965;">
<!ENTITY phi "&#966;">
<!ENTITY chi "&#967;">
<!ENTITY psi "&#968;">
<!ENTITY omega "&#969;">
<!ENTITY thetasym "&#977;">
<!ENTITY upsih "&#978;">
<!ENTITY piv "&#982;">
<!ENTITY OElig "&#338;">
<!ENTITY oelig "&#339;">
<!ENTITY Scaron "&#352;">
<!ENTITY scaron "&#353;">
<!ENTITY Yuml "&#376;">
<!ENTITY fnof "&#402;">
<!ENTITY circ "&#710;">
<!ENTITY tilde "&#732;">
<!ENTITY ensp "&#8194;">
<!ENTITY emsp "&#8195;">
<!ENTITY thinsp "&#8201;">
<!ENTITY zwnj "&#8204;">
<!ENTITY zwj "&#8205;">
<!ENTITY lrm "&#8206;">
<!ENTITY rlm "&#8207;">
<!ENTITY ndash "&#8211;">
<!ENTITY mdash "&#8212;">
<!ENTITY lsquo "&#8216;">
<!ENTITY rsquo "&#8217;">
<!ENTITY sbquo "&#8218;">
<!ENTITY ldquo "&#8220;">
<!ENTITY rdquo "&#8221;">
<!ENTITY bdquo "&#8222;">
<!ENTITY dagger "&#8224;">
<!ENTITY Dagger "&#8225;">
<!ENTITY bull "&#8226;">
<!ENTITY hellip "&#8230;">
<!ENTITY permil "&#8240;">
<!ENTITY prime "&#8242;">
<!ENTITY Prime "&#8243;">
<!ENTITY lsaquo "&#8249;">
<!ENTITY rsaquo "&#8250;">
<!ENTITY oline "&#8254;">
<!ENTITY euro "&#8364;">
<!ENTITY trade "&#8482;">
<!ENTITY larr "&#8592;">
<!ENTITY uarr "&#8593;">
<!ENTITY rarr "&#8594;">
<!ENTITY darr "&#8595;">
<!ENTITY harr "&#8596;">
<!ENTITY crarr "&#8629;">
<!ENTITY lceil "&#8968;">
<!ENTITY rceil "&#8969;">
<!ENTITY lfloor "&#8970;">
<!ENTITY rfloor "&#8971;">
<!ENTITY loz "&#9674;">
<!ENTITY spades "&#9824;">
<!ENTITY clubs "&#9827;">
<!ENTITY hearts "&#9829;">
<!ENTITY diams "&#9830;">
ENTITIES;

    private static $instance;

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
     * Dependencies assignments container.
     *
     * @var \Illuminate\Support\Collection
     */
    private $dependencies_assignments;

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
        $this->dependencies_assignments = collect();

        $this->dependencies_provider
            ->provideDependencies()
            ->each(function ($dependency) {
                $dependency->addAssignment($this->dependencies_assignments, $this->dependencies_data_provider);
            });
    }

    /**
     * Initialization.
     *
     * @param \Softworx\RocXolid\CMS\Elements\Models\Contracts\Element $element
     * @return \Softworx\RocXolid\CMS\Elements\Services\ContentCompiler
     */
    public static function init(Element $element): ContentCompiler
    {
        if (!self::$instance) {
            self::$instance = new static($element);
        }

        return self::$instance;
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

        $assignments = $this->dependencies_assignments->merge($assignments);

        return $this->compileContent($content, $assignments->all());
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

        collect($doc->getElementsByTagName('span'))->each(function (\DOMElement $span) use ($doc, $assignments) {
            if ($span->hasAttribute('data-dependency')) {
                $this->handleDependencyStatementNode($doc, $span, $assignments);
            }
        });

        while ($this->nodeHasMutators($doc)) {
            collect($doc->getElementsByTagName('span'))->each(function (\DOMElement $span) use ($doc, $assignments) {
                if ($span->hasAttribute('data-mutator') && !$this->nodeHasMutators($span)) {
                    $this->handleMutatorStatementNode($doc, $span, $assignments);
                }
            });
        }

        $content = $doc->saveHTML($doc->documentElement);
        $content = str_replace([ '<body>', '</body>' ], '', $content);
        $content = htmlspecialchars_decode($content);

        return $content;
    }

    /*
    protected function compileContent(string $content, array $assignments): string
    {
        // $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $entities_definition = self::XML_HTML_DEFS;

        $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE root [
            $entities_definition
        ]>
        <root
            xmlns:ac="http://www.atlassian.com/schema/confluence/4/ac/"
            xmlns:ri="http://www.atlassian.com/schema/confluence/4/ri/"
            xmlns="http://www.atlassian.com/schema/confluence/4/">
            $content
        </root>
        XML;

        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($xml);

        collect($doc->getElementsByTagName('span'))->each(function (\DOMElement $span) use ($doc, $assignments) {
            if ($span->hasAttribute('data-dependency')) {
                $this->handleDependencyStatementNode($doc, $span, $assignments);
            }
        });

        while ($this->nodeHasMutators($doc)) {
            collect($doc->getElementsByTagName('span'))->each(function (\DOMElement $span) use ($doc, $assignments) {
                if ($span->hasAttribute('data-mutator') && !$this->nodeHasMutators($span)) {
                    $this->handleMutatorStatementNode($doc, $span, $assignments);
                }
            });
        }

        $content = $doc->saveHTML($doc->documentElement);
        $content = str_replace([ '<body>', '</body>' ] , '', $content);
        $content = htmlspecialchars_decode($content);

        return $content;
    }
    */

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

        // @todo hardcoded exceptions
        if (collect([ '{PAGENO}', '{nb}' ])->contains($dependency_statement)) {
            return $dependency_statement;
        }

        // method calls
        $dependency_statement = preg_replace_callback('/::(\w+)/', function ($matches) {
            return sprintf('->%s()', $matches[1]);
        }, $dependency_statement);

        // attributes through \Softworx\RocXolid\Models\Traits\HasAttributes::getAttributeViewValue()
        $dependency_statement = preg_replace_callback('/:(\w+)/', function ($matches) {
            return sprintf('->getAttributeViewValue(\'%s\')', $matches[1]);
        }, $dependency_statement);

        // attributes access
        $dependency_statement = preg_replace_callback('/\.(\w+)/', function ($matches) {
            return sprintf('->%s', $matches[1]);
        }, $dependency_statement);

        // make it a variable to be interpreted
        $dependency_statement = sprintf('$%s', $dependency_statement);

        // making the chain optional to handle null pointers
        while (preg_match('/(.+->\w+)->(\w+)/', $dependency_statement)) {
            $dependency_statement = preg_replace_callback('/(.+->\w+)->(\w+)/', function ($matches) {
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

    protected function nodeHasMutators(\DOMNode $node): bool
    {
        return collect($node->getElementsByTagName('span'))->filter(function (\DOMElement $span) {
            return $span->hasAttribute('data-mutator');
        })->isNotEmpty();
    }
}
