<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="developer" content="flagstudio.ru">
    <meta name="cmsmagazine" content="3a145314dbb5ea88527bc9277a5f8274">
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <title>{{ isset($meta) ? $meta->getTagTitle() : ''  }}</title>

    <link href="{!! mix('/css/app.css') !!}" rel="stylesheet" type="text/css">

    <script src="{!! mix('/js/check-support.js') !!}" async></script>
    <script src="{!! mix('/js/manifest.js') !!}" async></script>
    <script src="{!! mix('/js/main.js') !!}" defer></script>
    <script src="{!! mix('/js/vendor.js') !!}" defer></script>

    {!! $headScripts ?? '' !!}
</head>
<body>
{!! $beginScripts ?? '' !!}

@if (auth()->user()?->isAdmin())
    {!! AdminBar::generate() !!}
@endif
<div id="app" class="main-wrapper">
    @yield('content')
</div>

@include('sprite')
{!! $endScripts ?? '' !!}

</body>
</html>
