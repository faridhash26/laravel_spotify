<?php

namespace Database\Seeders;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'farid',
            'email' => 'farid@gmail.com',
            'password' => bcrypt('1234'),
            'email_verified_at' => now(),
            'role_id' => 1, // Administrator
        ]);
    }
}
