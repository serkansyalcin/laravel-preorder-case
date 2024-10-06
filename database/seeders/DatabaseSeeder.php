<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'PreOrder',
            'email' => 'admin@admin.com',
            'is_admin' => 1,
            'password' => Hash::make('admin123')
        ]);

        User::factory()->create([
            'first_name' => 'User',
            'last_name' => 'PreOrder',
            'email' => 'user@user.com',
            'is_admin' => 0,
            'password' => Hash::make('admin123')
        ]);
    }
}
