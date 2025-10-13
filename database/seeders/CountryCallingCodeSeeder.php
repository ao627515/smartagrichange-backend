<?php

namespace Database\Seeders;

use App\Models\CountryCallingCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryCallingCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $callingCodes = readJsonFromPublic('assets/data/country_codes.json');

        if ($callingCodes) {
            foreach ($callingCodes as $callingCode) {
                CountryCallingCode::factory()->create([
                    'country' => $callingCode['country'],
                    'iso_code' => $callingCode['iso_code'],
                    'calling_code' => $callingCode['calling_code'],
                ]);
            }
        }
    }
}
