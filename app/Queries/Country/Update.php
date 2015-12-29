<?php


namespace App\Queries\Country;

use App\Country;
use App\CountryTranslation;
use Illuminate\Support\Facades\DB;


class Update
{
    public function run($input, $countryId)
    {
        $code = $input['code'];
        $translations = $input['translations'];

        DB::beginTransaction();

        Country::findOrFail($countryId)->update(['code' => $code]);

        foreach ($translations as $fields) {
            CountryTranslation::where('country_id', $countryId)
                ->where('lang', $fields['lang'])
                ->update([
                    'name' => $fields['name']
                ]);
        }

        DB::commit();
    }
}