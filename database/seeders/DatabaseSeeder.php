<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $countries = [
        //     ['name' => 'Afghanistan', 'code' => 'AF'],
        //     ['name' => 'Albania', 'code' => 'AL'],
        //     ['name' => 'Algeria', 'code' => 'DZ'],
        //     ['name' => 'Andorra', 'code' => 'AD'],
        //     ['name' => 'Angola', 'code' => 'AO'],
        //     ['name' => 'Antigua and Barbuda', 'code' => 'AG'],
        //     ['name' => 'Argentina', 'code' => 'AR'],
        //     ['name' => 'Armenia', 'code' => 'AM'],
        //     ['name' => 'Australia', 'code' => 'AU'],
        //     ['name' => 'Austria', 'code' => 'AT'],
        //     ['name' => 'Azerbaijan', 'code' => 'AZ'],
        //     ['name' => 'Bahamas', 'code' => 'BS'],
        //     ['name' => 'Bahrain', 'code' => 'BH'],
        //     ['name' => 'Bangladesh', 'code' => 'BD'],
        //     ['name' => 'Barbados', 'code' => 'BB'],
        //     ['name' => 'Belarus', 'code' => 'BY'],
        //     ['name' => 'Belgium', 'code' => 'BE'],
        //     ['name' => 'Belize', 'code' => 'BZ'],
        //     ['name' => 'Benin', 'code' => 'BJ'],
        //     ['name' => 'Bhutan', 'code' => 'BT'],
        //     ['name' => 'Bolivia', 'code' => 'BO'],
        //     ['name' => 'Bosnia and Herzegovina', 'code' => 'BA'],
        //     ['name' => 'Botswana', 'code' => 'BW'],
        //     ['name' => 'Brazil', 'code' => 'BR'],
        //     ['name' => 'Brunei', 'code' => 'BN'],
        //     ['name' => 'Bulgaria', 'code' => 'BG'],
        //     ['name' => 'Burkina Faso', 'code' => 'BF'],
        //     ['name' => 'Burundi', 'code' => 'BI'],
        //     // Add more countries as needed...
        // ];
        // DB::table('countries')->insert($countries);


        DB::table('users')->insert([

            [
                'name' => 'Jane Smith',
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'middlename' => null,
                'gender' => 'Female',
                'contact' => '0987654321',
                'email' => 'lebano@gmail.com',
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
