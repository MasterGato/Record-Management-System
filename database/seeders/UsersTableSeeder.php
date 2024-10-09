<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'middlename' => 'A.',
                'gender' => 'Male',
                'contact' => '1234567890',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'status' => 'Active',
                'branch_id' => 1, // Assuming this references 'Main Branch'
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'middlename' => null,
                'gender' => 'Female',
                'contact' => '0987654321',
                'email' => 'janesmith@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'role' => 'User',
                'status' => 'Active',
                'branch_id' => 2, // Assuming this references 'Secondary Branch'
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
