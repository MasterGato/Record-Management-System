<?php

// database/seeders/LocationSeeder.php

// database/seeders/LocationSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Barangay;
use Illuminate\Support\Facades\Storage;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // Load the JSON data
        $json = Storage::get('locations.json');
        $locations = json_decode($json, true);

        // Check if the locations data is valid
        if (is_null($locations)) {
            throw new \Exception('Invalid JSON data in locations.json');
        }

        foreach ($locations as $regionName => $regionData) {
            // Create a new region
            $region = Region::create(['region_name' => $regionData['region_name']]);

            foreach ($regionData['province_list'] as $provinceName => $provinceData) {
                // Create a new province
                $province = $region->provinces()->create(['province_name' => $provinceName]);

                foreach ($provinceData['municipality_list'] as $municipalityName => $municipalityData) {
                    // Create a new municipality
                    $municipality = $province->municipalities()->create(['municipality_name' => $municipalityName]);

                    foreach ($municipalityData['barangay_list'] as $barangayName) {
                        // Create a new barangay
                        $municipality->barangays()->create(['barangay_name' => $barangayName]);
                    }
                }
            }
        }
    }
}
