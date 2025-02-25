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
            'name' => 'Super Admin',
            'phone' => '0823283863',
            'email' => 'superadmin@gmail.com',
            'password' => '12345678',
        ])->assignRole('SuperAdmin');

        User::create([
            'name' => 'Admin',
            'phone' => '0823283862',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ])->assignRole('admin');
    }
}
