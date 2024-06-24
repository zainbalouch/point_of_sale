<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class ImportCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import countries from JSON file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Loading countries');
        $string = file_get_contents(public_path() . '//countries_states_cities.json');
        $countriesJson = json_decode($string, true);

        // $this->info('Inserting countries');

        foreach($countriesJson as $countryJson) {
            // $this->info('Inserting county: ' . $countryJson['name']);
            $country = new Country();
            $country->name = $countryJson['name'];
            $country->country_iso_code = $countryJson['iso2'];
            $country->save();
            // $this->info('Inserting states');
            foreach($countryJson['states'] as $stateJson) {
                // $this->info('Inserting state: ' . $stateJson['name']);
                $state = new State();
                $state->name = $stateJson['name'];
                $state->code = $stateJson['state_code'];
                $state->country_id = $country->id;
                $state->save();
                // $this->info('Inserting cities');
                foreach($stateJson['cities'] as $cityJson) {
                    // $city = City::where('name', $cityJson['name'])
                    //                 ->where('state_id', $country->id)
                    //                 ->first();
                    // if(!$city) {
                        // $this->info('Inserting city: ' . $cityJson['name']);
                    $city = new City();
                    $city->name = $cityJson['name'];
                    $city->state_id = $state->id;
                    $city->save();
                    // }
                }
            }
        }
    }
}
