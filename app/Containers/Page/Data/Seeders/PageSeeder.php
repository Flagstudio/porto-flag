<?php

namespace App\Containers\Page\Data\Seeders;

use App\Containers\Page\Domain\Models\Page;
use App\Containers\Page\Domain\Properties\Enums\PageEnum;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        if (Page::whereSlug(PageEnum::home)->doesntExist()) {
            Page::factory()
                ->create([
                    'title' => 'Main page',
                    'slug' => PageEnum::home,
                ]);
        }
    }
}
