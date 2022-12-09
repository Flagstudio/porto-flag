<?php

namespace App\Ship\Captain\Abstracts\Collections;

use Exception;
use Illuminate\Support\Collection as BaseCollection;

abstract class Collection extends BaseCollection
{
    public function __construct(array|BaseCollection $items = [])
    {
        parent::__construct();

        $this->addItems($items);
    }

    public function push(...$values): self
    {
        $this->addItems($values);

        return $this;
    }

    private function addItems(array|BaseCollection $items): void
    {
        foreach ($items as $value) {
            $this->checkInstance($value, $this->instance());

            $this->items[] = $value;
        }
    }

    public function checkInstance(mixed $value, string $class): bool
    {
        if (! $value instanceof $class) {
            throw new Exception("Item not instance of {$class}. Given " . gettype($value));
        }

        return true;
    }

    abstract public function instance(): string;
}
