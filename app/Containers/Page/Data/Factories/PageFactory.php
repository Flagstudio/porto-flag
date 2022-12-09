<?php

namespace App\Containers\Page\Data\Factories;

use App\Containers\Page\Domain\Models\Page;
use App\Ship\Captain\Abstracts\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
        ];
    }
}
