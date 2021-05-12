<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    private function getUniqueCountries(): array
    {
        $countriesRaw = Country::getCountries()->all();
        $countriesFiltered = array_unique($countriesRaw, SORT_REGULAR);
        sort($countriesFiltered);

        return $countriesFiltered;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = $this->getUniqueCountries();

        array_map(static function ($country) {
            Country::factory()->create($country);
        }, $countries);
    }
}
