<?php

namespace Softworx\RocXolid\CMS\Elements\MetaData\DisplayRules;

// rocXolid contracts
use Softworx\RocXolid\Contracts\Controllable;
use Softworx\RocXolid\Contracts\TranslationPackageProvider;
use Softworx\RocXolid\Contracts\TranslationDiscoveryProvider;
use Softworx\RocXolid\Contracts\TranslationProvider;
// rocXolid traits
use Softworx\RocXolid\Traits as Traits;
// rocXolid components
use Softworx\RocXolid\Components\General\Message;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependencyDataProvider;
// rocXolid cms elements display rule contracts
use Softworx\RocXolid\CMS\Elements\MetaData\DisplayRules\Contracts\DisplayRule;

/**
 * Abstract elementable dependency.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
abstract class AbstractDisplayRule implements DisplayRule, Controllable, TranslationDiscoveryProvider, TranslationProvider
{
    use Traits\Controllable;
    use Traits\TranslationPackageProvider;
    use Traits\TranslationParamProvider;
    use Traits\TranslationKeyProvider;

    /**
     * {@inheritDoc}
     */
    // protected $translation_package = 'rocXolid-cms'; // will throw exception, cause this is defined in the trait

    /**
     * {@inheritDoc}
     */
    abstract public function preventsElementDisplay(ElementableDependencyDataProvider $dependency_data_provider): bool;

    /**
     * {@inheritDoc}
     */
    public function getTranslatedTitle(TranslationPackageProvider $controller): string
    {
        return $this->setController($controller)->translate(sprintf('display-rule.%s.title', $this->provideTranslationKey()));
    }

    /**
     * {@inheritDoc}
     */
    public function translate(string $key, array $params = [], bool $use_raw_key = false): string
    {
        return Message::build($this, $this->getController())->translate($key, $params, $use_raw_key);
    }

    /**
     * {@inheritDoc}
     */
    protected function guessTranslationParam(): ?string
    {
        if ($this->hasController()) {
            throw new \RuntimeException(sprintf('No controller set for [%s]', get_class($this)));
        }

        return $this->getController()->provideTranslationParam();
    }
}
