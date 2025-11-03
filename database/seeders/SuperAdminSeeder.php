<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default super admin account
        User::create([
            'name' => 'Super Admin',
            'email' => 'audentkent@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'super-admin',
            'is_active' => true,
        ]);

        // Create example admin account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pmdkatingan.go.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
