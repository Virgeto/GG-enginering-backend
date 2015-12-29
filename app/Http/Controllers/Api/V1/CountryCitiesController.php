<?php


namespace App\Http\Controllers\Api\V1;

use App\Country;
use App\Http\Controllers\Controller;


class CountryCitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $countryId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($countryId)
    {

        $country = Country::translate()
            ->where('countries.id', $countryId)
            ->with([
                'cities' => function ($citiesQuery) {
                    $citiesQuery->translate();
                }
            ])
            ->first();

        return $this->response->ok($country);
    }

}
