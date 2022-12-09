<?php

namespace App\Ship\Captain\Abstracts\Domain\Factories;

use App\Ship\Captain\Abstracts\Entities\AbstractEntity;

abstract class Factory
{
    protected function writer($entity, string $property, mixed $value): void
    {
        $refObject = new \ReflectionObject($entity);

        $refProperty = $refObject->getProperty($property);

        $refProperty->setValue($entity, $value);
    }

    protected function reader($entity, string $property)
    {
        $refObject = new \ReflectionObject($entity);

        $refProperty = $refObject->getProperty($property);

        return $refProperty->getValue($entity);
    }

    abstract public function general(): AbstractEntity;
}
