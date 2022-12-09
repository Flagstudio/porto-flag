<?php

namespace Database\Seeders;

use App\Containers\Settings\Data\Seeders\SettingsSeeder;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
        ]);
    }
}
