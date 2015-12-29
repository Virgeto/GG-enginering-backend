<?php


namespace App\Queries\Country;

use App\Country;
use Illuminate\Support\Facades\DB;


class Store
{
    public function run($input)
    {
        $code = $input['code'];
        $translations = $input['translations'];

        DB::beginTransaction();

        $country = Country::create(['code' => $code]);

        foreach ($translations as $fields) {
            $country->translations()->create($fields);
        }

        DB::commit();
    }
}