<?php

namespace App\Ship\Captain\Abstracts\Factories;

use Illuminate\Database\Eloquent\Factories\Factory as BaseFactory;
use Illuminate\Support\Str;

abstract class Factory extends BaseFactory
{
    abstract public function definition();

    public static function resolveFactoryName(string $modelName)
    {
        $resolver = static::$factoryNameResolver ?: function (string $modelName) {
            $modelName = Str::replaceFirst('Entities', 'Factories', $modelName);
            $modelName = Str::replaceFirst('Models', 'Factories', $modelName);
            $modelName = Str::replaceFirst('Domain', 'Data', $modelName);

            return $modelName . 'Factory';
        };

        return $resolver($modelName);
    }
}
