<?php

namespace App\Ship\Captain\Abstracts\Factories;

trait HasFactory
{
    public static function factory(...$parameters)
    {
        $factory = static::newFactory() ?: Factory::factoryForModel(static::class);

        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    protected static function newFactory()
    {
    }
}
