<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123123123'),
            'email_verified_at' => now(),
        ])->syncRoles('Administrator');

        User::create([
            'name' => 'reader',
            'email' => 'reader@reader.com',
            'password' => bcrypt('123123123'),
            'email_verified_at' => now(),
        ])->syncRoles('Reader');
    }
}
