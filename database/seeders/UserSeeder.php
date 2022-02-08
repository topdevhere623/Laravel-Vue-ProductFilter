<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\User::factory()->create(['email' => 'admin@example.com']);
        $admin->assignRole('admin');
        $user = \App\Models\User::factory()->create(['email' => 'client@example.com']);
        $user->assignRole('client');
        $user = \App\Models\User::factory()->create(['email' => 'user@example.com']);
        $user->assignRole('user');
    }
}
