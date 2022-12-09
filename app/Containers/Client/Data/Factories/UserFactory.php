<?php

namespace App\Containers\Client\Data\Factories;

use App\Containers\Client\Domain\Models\User;
use App\Ship\Captain\Abstracts\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt(rand(1000, 9999)),
            'phone' => '+79' . rand(100000000, 999999999),
            'birthday' => $this->faker->date('Y-m-d', now()->subYear(10)),
        ];
    }
}
