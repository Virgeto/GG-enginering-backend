<?php


namespace App\Queries\City;

use App\City;
use App\CityTranslation;


class Update
{

    /**
     * Update City by given id.
     *
     * @param $input
     * @param $cityId
     */
    public function run($input, $cityId)
    {

        $translations = $input['translations'];

        City::findOrFail($cityId);

        foreach ($translations as $fields) {
            CityTranslation::where('city_id', $cityId)
                ->where('lang', $fields['lang'])
                ->update([
                    'name' => $fields['name']
                ]);
        }
    }
}