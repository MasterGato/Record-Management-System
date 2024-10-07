<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;

class DefaultUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed the branches table
        $branch = Branch::first();
        // Seed the users table
        User::create([
            'name' => 'AdminUser',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'middlename' => 'Middle',
            'gender' => 'Female',  // or 'Male', as per your requirements
            'contact' => '09123456789',
            'email' => 'SuperAdmin@gmail.com',
            'password' => bcrypt('password123'), // Make sure to hash the password
            'role' => 'admin', // You can customize this based on your roles
            'status' => 'active', // or 'inactive', as per your requirements
            'branch_id' => $branch->id,
        ]);
    }
}
