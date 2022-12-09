<?php

namespace App\Ship\Captain\Abstracts\Tests\PhpUnit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use DatabaseTransactions;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fixSqliteDropForeignKey();
    }

    public function setUp(): void
    {
        parent::setUp();

        Http::fake();

        Bus::fake();

        Event::fake();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }
}
