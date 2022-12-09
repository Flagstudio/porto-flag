<?php

namespace App\Containers\Client\Domain\Tests\Unit\Models;

use App\Containers\Client\Domain\Models\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

class UserTest extends TestCase
{
    public function testUserIsNotAdmin()
    {
        $user = User::make([
            'name' => 'Alex',
        ]);

        $this->assertFalse($user->isAdmin());
    }

    public function testUserIsAdmin()
    {
        $user = User::make([
            'name' => 'Alex',
            'role' => 'admin',
        ]);

        $this->assertTrue($user->isAdmin());
    }

    public function testUserIsEditor()
    {
        $user = User::make([
            'name' => 'Alex',
            'role' => 'editor',
        ]);

        $this->assertTrue($user->isEditor());
    }
}
