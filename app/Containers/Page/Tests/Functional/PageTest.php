<?php

namespace App\Containers\Page\Tests\Functional;

use App\Ship\Parents\Tests\PhpUnit\TestCase;

class PageTest extends TestCase
{
    public function testMain()
    {
        $this->get(route('main'))
            ->assertOk();
    }
}
