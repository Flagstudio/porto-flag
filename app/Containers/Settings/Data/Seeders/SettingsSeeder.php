<?php

namespace App\Containers\Settings\Data\Seeders;

use App\Containers\Settings\Domain\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $metricsSlug = Settings::METRICS_SLUG;
        if (Settings::whereSlug($metricsSlug)->doesntExist()) {
            Settings::factory()->create([
                'title' => 'Метрики',
                'slug' => $metricsSlug,
                'fields' => [],
            ]);
        }

        $robotsSlug = Settings::ROBOTS_SLUG;
        if (Settings::whereSlug($robotsSlug)->doesntExist()) {
            Settings::factory()->create([
                'title' => 'Robots.txt',
                'slug' => $robotsSlug,
                'fields' => [
                    'robots' => "User-agent: *\nDisallow: /",
                ],
            ]);
        }
    }
}
