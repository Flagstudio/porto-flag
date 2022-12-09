<?php

namespace App\Containers\Client\Data\Seeders;

use App\Containers\Client\Domain\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createAdmin();
    }

    private function createAdmin(): void
    {
        if (! config('app.admin_password')) {
            throw new \Exception('Environment variable ADMIN_PASSWORD is required. You can set it in .env file');
        }

        if (User::whereEmail('admin@flag.ru')->doesntExist()) {
            User::factory()->create([
                'phone' => '+79999999999',
                'name' => 'Flagstudio',
                'email' => 'admin@flag.ru',
                'password' => bcrypt(config('app.admin_password')),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]);
        } else {
            User::whereEmail('admin@flag.ru')
                ->update([
                    'password' => bcrypt(config('app.admin_password')),
                ]);
        }
    }
}
