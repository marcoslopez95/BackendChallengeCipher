<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Test admin',
            'email' => 'admin@example.com',
        ]);

        $admin->roles()->attach( Role::ADMIN );

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        $user->roles()->attach( Role::USER );
    }
}
