<?php

namespace Database\Seeders;

use App\Containers\Client\Data\Seeders\UserSeeder;
use App\Containers\Page\Data\Seeders\PageSeeder;
use App\Containers\Settings\Data\Seeders\SettingsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingsSeeder::class,
            PageSeeder::class,
        ]);
    }
}
