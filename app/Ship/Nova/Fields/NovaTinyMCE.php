<?php

namespace App\Ship\Nova\Fields;

use Laravel\Nova\Fields\Field;

class NovaTinyMCE extends Field
{
    public $showOnIndex = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'Nova-TinyMCE';

    public function __construct(string $name, ?string $attribute = null, mixed $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(
            [
                'options' => [
                    'path_absolute' => '/',
                    'plugins' => [
                        'lists preview hr anchor pagebreak',
                        'wordcount fullscreen',
                        'contextmenu directionality',
                        'paste textcolor colorpicker textpattern',
                    ],
                    'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
                    'relative_urls' => false,
                    'use_lfm' => false,
                    'lfm_url' => 'laravel-filemanager',
                ],
            ]
        );
    }

    public function options(array $options): self
    {
        $currentOptions = $this->meta['options'];

        return $this->withMeta(
            [
                'options' => array_merge($currentOptions, $options),
            ]
        );
    }
}
