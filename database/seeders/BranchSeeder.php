<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            [
                'branchname' => 'Main Branch',
                'region' => 'Region 1',
                'province' => 'Province 1',
                'city' => 'City 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branchname' => 'Secondary Branch',
                'region' => 'Region 2',
                'province' => 'Province 2',
                'city' => 'City 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
