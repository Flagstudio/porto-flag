# Документация к сайту

Разработчик: [Студия Флаг](https://flagstudio.ru)

Дата публикации API: 30.11.2021

## Структура Docker Compose

### Конфиги Docker Compose

- **docker-compose.yml** — для локальной разработки
- **docker-compose.test.yml** — для сборки образа для тестовой площадки
- **docker-compose.staging.yml** — для сборки образа для staging площадки
- **docker-compose.prod.yml** — конфиг для запуска на проде. Лежит на проде, переименованный в docker-compose.yml
- **docker-compose.build-base.yml** — конфиг для сборки базовых образов. Не должен использоваться разработчиками, так как нужен для создания образов **общих для всех проектов веб-студии**

### Сервисы:
- app
    + Debian base (registry.gitlab.com/flagstudio/tairai:base)
    + Node 12
    + PHP: 8.1.1
    + Laravel: ^8.73
- postgres
    + dockerhub image (Postgres:13)
- postgrestest (используется для запусков тестов с базой postgres)
    + dockerhub image (Postgres:13)
- traefik (для локальной разработки)
    + dockerhub image (Traefik:2.5.6)
- redis (Используется для сессий, кэша)
    + dockerhub image (redis:6.2.5-buster)

### Конфиги

Общие

- **.env** — единственный конфиг не под Git'ом, поэтому в нем хранятся все настройки сайта и докера
- **docker/app/www.conf** — php-fpm
- **docker/app/laraflag.ini** — php
- **docker/app/crontab** — cron

Local

- **docker/app/supervisord_local.conf** — supervisor
- **docker/app/xdebug.ini** — xdebug

Prod

- **docker/app/opcache.ini** — opcache
- **docker/app/supervisord_build.conf** — supervisor

## LOCAL

Используйте `docker-compose.yml`, запускайте нужные службы, собирайте зависимости в `app`. Вот несоклько полезных команд для запуска на локале:

```shell
dc up -d — запуск проекта
dc up --build -d app — пересобрать образ и перезапустить контейнер
dc exec app composer install — выполнение команд в контейнере
dc exec app bash — подключиться к контейнеру
```

## Сборка базового образа

```shell
dc -f docker-compose.build-base.yml build - собираем образ
docker push registry.gitlab.com/<REPOSITORY_NAME>/<COMPOSE_PROJECT_NAME>:base - пушим в репозиторий
```

## PreCommit hooks

- Если хук возвращает code style errors, пофиксите с помощью команды: `dc exec app composer csfix`, добавьте изменения в коммит.
- Чтобы запустить ТОЛЬКО проверку на code style: `dc exec app composer csfix-validate`, команда вернет список проблемных файлов.
- Если pre_commit hook содержит ошибки тестов, чиним тесты и запускаем проверку заново.

## Tests

- Запустите `php artisan test`

# Запуск проекта

```shell
cp .env.example .env
```

Заполняем `.env` файл. Необходимо указать корретные значения для подключения к базе данных, `COMPOSE_PROJECT_NAME` должен совпадать с именем сети в файле `docker-compose.yml`. После этого можно пробовать поднимать проект.

Первым шагом будет сборка базового образа. После этого пробуем поднять контейнеры проекта:

```shell
docker-compose up -d
docker-compose exec app composer i
docker-compose exec app npm i
docker-compose exec app npm run dev
docker-compose migrate --seed
docker-compose exec app php artisan key:generate
```

***
***

# Laraflag Porto

## Введение

[Здесь][1] можно почитать про концепцию Porto от его создателя. А [это][2] его собственная реализация Porto на laravel. Можно развернуть и потыкать при желании. Или просто подстмотреть что-то и взять к себе в проект.

[1]: https://github.com/Mahmoudz/Porto
[2]: https://github.com/apiato/apiato

В сборке предполагается использование подхода TDD при разработке. Поэтому тесты настроены, чтобы они запускались у каждого контейнера и корабля.

***

## Концепция

В Porto приложение делится на два слоя: контейнеры и корабль. Слой корабля отвечает за логику приложения, а контейнеры(они же домены/модули) отвечают за бизнес логику. Все компоненты контейнеров должны наследоваться только от классов из коробля(Ship/Parents/*). Если вы добавляете новый пакет, от которого ван нужно наследовать свои компоненты в контейнере, то ДОЛЖНЫ быть родительские классы в слое коробля, наследующие классы пакетов, и только от них уже наследуются компоненты.
В Porto ещё допускается объединение нескольких контейнеров в однин раздел (section). Это допускается если контейнеры имеют связи между собой. Например таким образом мы может объединить в один раздел интеграции приложений.

> Можете посмотреть как выглядит раздел Integrations.

Так как мы делим наше приложение на отдельные контейнеры, то у нас обязательно возникнил ситуация, когда в компонентах одного контейнера нам понядобятся компоненты других контейнеров. В таких случаях нужно использовать контракты (интерфейсы).

> Можно посмотреть на примере контейнера `Payment`. Ему нужен функционал из контейнера `Integrations\Robokassa`

***

## Слой контейнера

Подробнее рассмотрим из чего состоит контейнер:

```
Container
├── Actions
├── Configs
├── Console
├── Contracts
├── Data
|   ├── Factories
|   ├── Migrations
|   └── Seeders
├── Domain
|   ├── Collections
|   ├── Commands
|   ├── Сriterias
|   ├── Entities
|   ├── Enums
|   ├── Exceptions
|   ├── Factories
|   ├── Models
|   ├── Repositories
|   ├── Tests
|   └── Values
├── Events
├── Exceptions
├── Http
|   ├── Composers
|   ├── Controllers
|   ├── Middlewares
|   ├── Responders
|   └── Requests
├── Jobs
├── Listeners
├── Mails
├── Nova
|   ├── Actions
|   ├── Filters
|   └── Resources
├── Notifications
├── Providers
├── Routes
├── Tasks
├── Tests
|   ├── Feature
|   └── Unit
└── Transfers
    ├── Resources
    └── Transporters
```

> Данная структура ещё дорабатывается и подлежит обсуждению.

### Action

<a id="Action"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Сюда мы выносим всю логику из контроллера. Один класс - одно действие. Список actions должен полностью отображать, что может делать контейнер.

> Например, если мы может получить профиль пользователя, то для этого у нас будет отдельный action.

Action в себе содержит только один метод `run`, который на вход принимает класс наследник `Transporter` из контроллера. Структура action должна быть предельно ленейной минимум ветвлений `if` или `switch`. Его содержание долно просто читаться сверху вниз. Также кроме метода `run` ничего быть не должно. При необходимости часть работы `action` МОЖЕТ дилегировать в `task-и` или сервисы.

```php
namespace App\Containers\User\Actions;

use ...

class UserUpdateAction extends Action
{
    public function run(UserUpdateTransporter $transporter): Responder
    {
        $this->task(UserUpdateTask::class, $transporter);

        return $this->responder(UserUpdatedResponder::class);
    }
}
```

`Action` может вызвать `Task`, `Responder`, `SubAction`, `Command`. Также он сам может быть вызван из `Controller`, `Command`, `Listener`, `Job`.

> В примере для обновления пользователя используется `Task`. Сейчас ответственность за обновление/создание/удаление переходит к классам `Domain\Commands`. Это сделано для реализации подхода CQS/CQRS. Почему не использовать для этих целей `Task-и`? Очень просто, ответственность `Task-ов` слишком размыта. И целесообразность их спользования сейчас находится под большим вопросом.

***

</Details>

### Console

Содержат необходимые команды для работы контейнера. Команды могут вызывать `Action-ы`

### Configs

Содержат необходимые конфиги для работы контейнера

### Criterias (__дорабатывается__)

<a id="Criterias"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Класс в который мы просто выносим наши scope-методы из моделей. Например мы хотим найти всех мастеров, которые относятся к отпределённому салону. Для этого мы создаём класс критерий, который на вход принимает экземпляр салона.

```php
<?php

namespace App\Containers\Master\Domain\Criterias;

use App\Ship\Parents\Criterias\Criteria;

class AdminCriteria extends Criteria
{
    public function apply($query)
    {
        $query->where('role', 'admin');
    }
}
```

***

</Details>

### Entities

Сейчас сущности не имеют родительских классов. Они описывают объектами которыми мы оперируем в нашем контейнере. Должны содержать набор свойств и методов для работы с сущностью. Взяты из DDD.

### Enums

Появились в PHP 8.1. Может использоваться вместо `ValueObject`, как и `Collection`.

***

</Details>

### Repositories

Репозитории используются для извлечения сущностей из хранилища (БД, файлы, кэш и т.д.).

### Seeders

Сейчас сиды лежат в обычном месте. Нужно добавить загрузчик сидов, чтобы их можно было по имени запускать из любого контейнера. Сейчас просто подключаются в `DatabaseSeeder`.

### Values

//TODO
Сейчас думаю, как это сделать наиболее простым и удобным способом, чтобы не заставлять разработчика плодить кучи объектов, которых и так уже не мало выходит. Возможно и не так страшно дабавить парочку. Одним больше, одним меньше...

### Exceptions

Исключениями должно быть покрыто максимальное количество кода. Например, `Action-ы` и `Task-и` в 99% случаев должны иметь хотябы одно исключение.

### Controllers

Контроллер принимает `Request` и вызывает `Action`. Формирование правильного ответа занимается `Action`. Контроллер не может вызывать компоненты ниже `Action` в иерархии.

### Responders

Принимает данные, которые упаковывает либо во `view`, либо в виде `json response`

### Requests

<a id="Requests"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Обычный реквест, но с добавлением `Transporter` (DTO). это позволяем достать из запроса отвалидированные данные в видео объекта и быть уверенным, что все необходимые данные (свойства класса DTO) будут нам доступны в правильном наборе. В запросе указываем в методе `transporter()` `namespace` нашего транспортера:

```php
namespace App\Containers\User\Http\Requests;

use ...

class UserUpdateRequest extends Request
{
    ...

    public function transporter(): string
    {
        return UserUpdateTransporter::class;
    }

    ...
}
```

Затем в контроллере достаём эти данные из запроса, вызовом метода `transportered()`:

```php
namespace App\Containers\User\Http\Controllers;

use ...

class UserController extends Controller
{
    ...

    public function update(UserUpdateRequest $request)
    {
        $response = $this->action(
            UserUpdateAction::class,
            $request->transportered(),
        );

        return response()->json($response);
    }
    
    ...
}
```

И дальше в `Action` мы принимаем не какой-то массив, с неясным набором полей, а конкретный экземпляр класса, где может быть точно уверены, что данные там есть:

```php
namespace App\Containers\User\Actions;

use ...

class UserUpdateAction extends Action
{
    public function run(UserUpdateTransporter $transporter)
    {
        //code...
    }
}
```

***

</Details>

### Nova

`Resource`, `Action` и `Filter` помещаются внутри контейнера поближе к домену.

### Routes

Рауты делятся на два вида `api` и `web`, как и у Laravel. Но теперь они помещены в каждый контейнер и хранятся отдельно от других.

### Tasks

<a id="Requests"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Задачи - это класс, который не содержит в себе бизнес логику. В нём хранится линь маленькое унарное действие. Они нужны для убирания дублирования из нашего кода. их использование не обязательно в `Action-ах`, однако проще сразу вынести какую-то операцию в `Task` и переиспользовать при необходимости, чем потом искать все места и заменять на `Task-и`.
`Task` может работать с моделью либо её репозиторием и не вызывать компонемны выше него по иерархии. Его могет вызывать только `Action` и `SubAction`

```php
namespace App\Containers\User\Tasks;

use ...

class FindUserByPhoneTask extends Task
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $phone)
    {
        return $this->repository->getByPhone($phone);
    }
    
    ...
}
```

> Пример кода выше является лишь ПРИМЕРОМ и НЕ рекомендуется создавать отдельный класс для простого вызова одного метода репозитория. Репозитории можно и нужно использовать сразу в `Action`, не увеличивая искуственно сложность и запутанность проекта.

***

</Details>

### Tests

Тесты для проверки функциональнсти контейнера. И не забываем ПИСАТЬ ТЕСТЫ, даже простые. Тесты должны быть у каждого контейнера. Не забываем про TDD, поэтому не стеняемся писать тест на то чего ещё нет.

### Transfers

DTO объекты. Используется пакет от Spatie.

### Resources

[API Resources](https://laravel.com/docs/8.x/eloquent-resources)

### Transporters

<a id="Requests"></a>
<Details>
<Summary>Подробнее</Summary>
<br>

Преобразует отвалидированные данные из запроса в объект DTO. Для его использования достаточно создать класс транспортера используя команду в консоли `php artisan flag:transporter`. Затем добавить в класс закроса в методе `transporter()`

```php
namespace App\Containers\User\Transfers\Transporters;

use ...

class UserUpdateTransporter extends Transporter
{
    public string $name;
    
    public string $phone;
    
    public string $email;
    
    public string $birthday;
    
    #[MapFrom('offers')]
    public bool $allowAds;

}
```

```php
namespace App\Containers\User\Http\Requests;

use ...

class UserUpdateRequest extends Request
{
    public function transporter(): string
    {
        return UserUpdateTransporter::class;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'phone' => 'nullable|numeric|regex:/\+79[0-9]{9}/',
            'email' => 'nullable|email',
            'birthday' => 'nullable|date',
            'offers' => 'nullable|boolean',
        ];
    }
}
```

***

</Details>
