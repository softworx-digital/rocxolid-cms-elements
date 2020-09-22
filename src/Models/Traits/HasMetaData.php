<?php

namespace Softworx\RocXolid\CMS\Elements\Models\Traits;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid cms elements meta data contracts
use Softworx\RocXolid\CMS\Elements\MetaData\Contracts\MetaDataOperator;

/**
 * Trait for an element to enable meta data.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS\Elements
 * @version 1.0.0
 */
trait HasMetaData
{
    private $provided_meta_data;

    /**
     * Meta data attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getMetaDataAttribute($value): Collection
    {
        return collect(json_decode($value, true))->filter();
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailableMetaData(): Collection
    {
        return $this->getAvailableMetaDataTypes()->transform(function (string $type) {
            return app($type, [
                'element' => $this
            ]);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function provideMetaData($reload = false): Collection
    {
        if ($reload || !isset($this->provided_meta_data)) {
            $this->provided_meta_data = $this->meta_data->transform(function (string $value, string $type) {
                return app($type, [
                    'element' => $this
                ])->setValue($value);
            });
        }

        return $this->provided_meta_data;
    }

    /**
     * {@inheritDoc}
     */
    public function isMetaData(string $type): bool
    {
        return $this->meta_data->has($type);
    }

    /**
     * {@inheritDoc}
     */
    public function fillMetaData(Collection $data): Crudable
    {
        $this->getAvailableMetaData()->each(function (MetaDataOperator $meta_data) use ($data) {
            $meta_data->fill($data);
        });

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaData(): ?string
    {
        $meta_data = $this->provideMetaData(true);

        if ($meta_data->isNotEmpty()) {
            // encoding to base64 because of problems with JSON in HTML data-* attributes
            // @todo: ugly
            return base64_encode($meta_data->mapWithKeys(function (MetaDataOperator $meta_data_operator) {
                if (class_exists($meta_data_operator->getValue())) {
                    $value = app($meta_data_operator->getValue())->getTranslatedTitle($this->getCrudController());
                } else {
                    $value = $meta_data_operator->getValue();
                }

                return [
                    $meta_data_operator->provideMetaDataFieldName() => [
                        'title' => __(sprintf(
                            'rocXolid:cms-elements::%s.field.meta_data.%s',
                            $this->getModelName(),
                            $meta_data_operator->provideMetaDataFieldName()
                        )),
                        'value' => $value,
                    ]
                ];
            }));
        }

        return null;
    }

    /**
     * Check if element's meta data operators prevent the element to be displayed when being rendered.
     *
     * @return bool
     */
    protected function isDisplayedByMetaData(): bool
    {
        return !$this->provideMetaData()->reduce(function (bool $carrier, MetaDataOperator $meta_data_operator) {
            return $carrier || $meta_data_operator->preventsElementDisplay();
        }, false);
    }

    /**
     * Adjust the rendered content by element's meta data operators before final output.
     *
     * @param string $content
     * @param array $assignments
     * @return string
     */
    protected function adjustRenderedContentByMetaData(string $content, array $assignments = []): string
    {
        $meta_data = $this->provideMetaData();

        if ($this !== $this->getContainer()) {
            $meta_data = $meta_data->merge($this->getContainer()->provideMetaData());
        }

        return $meta_data->reduce(function (string $carrier, MetaDataOperator $meta_data_operator) use ($assignments) {
            return $meta_data_operator->adjustRenderedContent($this, $carrier, $assignments);
        }, $content);
    }

    /**
     * Obtain available meta data types that can be assigned to the model.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableMetaDataTypes(): Collection
    {
        return static::getConfigData('available-meta-data');
    }
}
