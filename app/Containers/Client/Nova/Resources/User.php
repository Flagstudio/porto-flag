<?php

namespace App\Containers\Client\Nova\Resources;

use App\Containers\Client\Traits\RoleManager;
use App\Ship\Nova\Resource;
use App\Ship\Rules\PasswordRule;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    use RoleManager;

    public static string $model = \App\Containers\Client\Domain\Models\User::class;

    public static $title = 'name';

    public static $category = 'Основные';

    public static $search = [
        'phone',
        'name',
        'email',
    ];

    public static $group = [
        'Пользователи',
    ];

    public static function label(): string
    {
        return 'Пользователи';
    }

    public static function singularLabel(): string
    {
        return 'Пользователь';
    }

    public function fields(Request $request): array
    {
        return [
            Text::make('Телефон', 'phone')
                ->sortable()
                ->readonly(),

            Text::make('Имя', 'name')
                ->sortable()
                ->rules('required', 'max:21'),

            Text::make('Email')
                ->sortable()
                ->rules('email', 'max:50')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Date::make('Дата рождения', 'birthday'),

            Password::make('Пароль', 'password')
                ->updateRules([
                    new PasswordRule,
                ])
                ->help("Ожидается от 6 до 16 символов с числом и как минимум одной прописной буквой")
                ->onlyOnDetail(),
        ];
    }

    public static function authorizedToViewAny(Request $request)
    {
        return self::admin()->can()
            || self::editor()->cannot()
            || self::contentManager()->cannot();
    }

    public function authorizedToView(Request $request): bool
    {
        return $this->getAdmin()->can()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }

    public function authorizedToUpdate(Request $request)
    {
        return $this->getAdmin()->can()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }

    public function authorizedToAdd(NovaRequest $request, $model)
    {
        return $this->getAdmin()->can()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }

    public function authorizedToDelete(Request $request)
    {
        return $this->getAdmin()->can()
            || $this->getEditor()->cannot()
            || $this->getContentManager()->cannot();
    }
}
