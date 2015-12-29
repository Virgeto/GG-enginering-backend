<?php


namespace App\Queries\City;

use App\Country;
use Illuminate\Support\Facades\DB;
use App\City;


class Store
{

    /**
     * Store new City in Database.
     *
     * @param $input
     */
    public function run($input)
    {
        $translations = $input['translations'];
        $countryId = $input['country_id'];

        DB::beginTransaction();

        $city = new City();
        $city->country()->associate(Country::findOrFail($countryId));
        $city->save();

        foreach ($translations as $fields) {
            $city->translations()->create($fields);
        }

        DB::commit();
    }
}