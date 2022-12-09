<?php

namespace App\Ship\Nova;

use App\Ship\Nova\Fields\NovaTinyMCE;
use Closure;
use Ebess\AdvancedNovaMediaLibrary\Fields\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;
use R64\NovaFields\JSON;
use SLASH2NL\NovaBackButton\NovaBackButton;

abstract class Resource extends NovaResource
{
    public static string $model;

    protected static string $identificator = 'id';

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query;
    }

    public static function scoutQuery(NovaRequest $request, $query): \Laravel\Scout\Builder
    {
        return $query;
    }

    public function json(array $fields, string $columnName = 'fields'): JSON
    {
        return JSON::make($columnName, $fields)
            ->hideLabelInDetail()
            ->hideLabelInForms()
            ->flatten();
    }

    public function tiny(string $displayingName, ?string $columnName = null): NovaTinyMCE
    {
        $columnName = $columnName ?? $displayingName;

        return NovaTinyMCE::make($displayingName, $columnName)
            ->options(config('nova.tinymce_options'));
    }

    public function media(string $displayingName, ?string $collectionName = null): Media
    {
        return Media::make($displayingName, $collectionName);
    }

    public function link(string $title, string $url, string $text): Text
    {
        return Text::make($title, fn () => '<a class="no-underline dim text-primary font-bold" href="' . $url . '" target="_blank">' . $text . ' </a>')
            ->exceptOnForms()
            ->asHtml();
    }

    public static function getHashMediaFunc(): Closure
    {
        return function ($originalFilename, $extension) {
            return Str::slug(explode('.', $originalFilename)[0]) . '.' . $extension;
        };
    }

    public static function meta($jsonColumn = 'meta')
    {
        return JSON::make($jsonColumn, [
            Text::make('Тег <title>', 'tag_title'),
            Text::make('Title', 'title'),
            Text::make('Description', 'description'),
            Text::make('Keywords', 'keywords'),
        ])
            ->fieldClasses('w-full')
            ->hideLabelInDetail()
            ->hideLabelInForms();
    }

    public function cards(Request $request)
    {
        return [
            (new NovaBackButton())
                ->onlyOnDetail()
                ->withMeta([
                    'content' => '<span class="btn btn-icon btn-default btn-white" style="position: absolute; top: -1.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current text-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </span>',
                    'url' => '/resources/' . Str::plural(Str::kebab(class_basename($this))),
                ]),
        ];
    }

    protected function identificator(): int
    {
        $identificatorName = static::$identificator;
        $identificator = $this->$identificatorName;
        if (! $identificator && $resourceId = request()->resourceId) {
            $identificator = static::$model::find($resourceId)->$identificatorName;
        }

        return $identificator;
    }
}
