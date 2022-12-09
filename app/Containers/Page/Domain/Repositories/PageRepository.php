<?php

namespace App\Containers\Page\Domain\Repositories;

use App\Containers\Page\Domain\Models\Page as Model;
use App\Containers\Page\Domain\Properties\Enums\PageEnum;
use App\Ship\Parents\Repositories\Repository;

class PageRepository extends Repository
{
    public function model(): string
    {
        return Model::class;
    }

    public function main()
    {
        return $this->whereSlug(PageEnum::home)->firstOrFail();
    }
}
