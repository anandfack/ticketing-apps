<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN USER
        $admin = User::create([
            'employee_id' => 'EMP-0001',
            'username' => 'admin',
            'email' => 'admin@system.com',
            'password' => Hash::make('password'),
            'full_name' => 'System Admin',
            'is_active' => true,
        ]);

        $admin->assignRole('admin');
    }
}