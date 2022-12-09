<?php

namespace App\Containers\Settings\Nova;

use App\Containers\Client\Traits\RoleManager;
use App\Containers\Settings\Domain\Models\Settings as SettingsModel;
use App\Ship\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Settings extends Resource
{
    use RoleManager;

    public static string $model = SettingsModel::class;

    public static $title = 'title';

    public static $group = [
        'Настройки',
    ];

    public static $category = 'Настройки';

    public static function label(): string
    {
        return 'Общие';
    }

    public static function singularLabel(): string
    {
        return 'Настройки';
    }

    public function fields(Request $request): array
    {
        $defaultFields = [
            Text::make('Title')
                ->onlyOnIndex(),
        ];

        $slug = $this->slug ?? '';
        switch ($slug) {
            case SettingsModel::ROBOTS_SLUG:
                $fields = $this->robotsFields();

                break;
            case SettingsModel::METRICS_SLUG:
                $fields = $this->metricsFields();

                break;
            case SettingsModel::VERSIONS_SLUG:
                $fields = $this->versionsFields();

                break;
            default:
                $fields = [];

                break;
        }

        return [
            ...$defaultFields,
            ...$fields,
        ];
    }

    private function robotsFields(): array
    {
        return [
            $this->json([
                Textarea::make('Robots.txt', 'robots')
                    ->rows(10),
            ]),
        ];
    }

    private function metricsFields(): array
    {
        return [
            $this->json([
                Textarea::make('Внутри тега head', 'scripts_head'),
                Textarea::make('После открывающего тега body', 'scripts_begin'),
                Textarea::make('Перед закрывающем тегом body', 'scripts_end'),
            ]),
        ];
    }

    private function versionsFields(): array
    {
        return [
            $this->json([
                Heading::make('Android'),
                Text::make('Ссылка', 'android->link'),
                Text::make('Версия', 'android->version'),

                Heading::make('IOS'),
                Text::make('Ссылка', 'ios->link'),
                Text::make('Версия', 'ios->version'),

                Boolean::make('Проверять версию', 'is_checking'),
                Boolean::make('Принудительное обновление', 'is_blocking'),
            ]),
        ];
    }

    public static function authorizedToViewAny(Request $request)
    {
        return self::admin()->can()
            || self::editor()->cannot()
            || self::contentManager()->can();
    }

    public function authorizedToView(Request $request): bool
    {
        return $this->getAdmin()->can()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->can();
    }

    public function authorizedToUpdate(Request $request)
    {
        return $this->getAdmin()->can()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }

    public function authorizedToAdd(NovaRequest $request, $model)
    {
        return $this->getAdmin()->cannot()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }

    public function authorizedToDelete(Request $request)
    {
        return $this->getAdmin()->cannot()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }

    public static function authorizedToCreate(Request $request)
    {
        return self::admin()->cannot()
            || self::editor()->cannot()
            || self::contentManager()->cannot();
    }

    public static function searchable()
    {
        return self::admin()->cannot()
            || self::editor()->cannot()
            || self::contentManager()->cannot();
    }
}
