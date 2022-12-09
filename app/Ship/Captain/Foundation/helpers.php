<?php

/*
 * You can define global functions in this file
 */

if (! function_exists('container_path')) {
    function container_path(string $path): string
    {
        return app_path('Containers/' . $path);
    }
}

if (! function_exists('ship_path')) {
    function ship_path(string $path = ''): string
    {
        return app_path('Ship/' . $path);
    }
}

if (! function_exists('money_format')) {
    function money_format(float $money): string
    {
        return number_format(
            num: $money,
            thousands_separator: ' ',
        );
    }
}
