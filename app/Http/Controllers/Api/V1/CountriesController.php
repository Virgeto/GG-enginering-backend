<?php


namespace App\Http\Controllers\Api\V1;

use App\Country;
use App\CountryTranslation;
use App\Queries\Country\Store;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;


class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $countries = Country::translate()->paginate(getPerPage());

        return $this->response->ok($countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CountryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CountryRequest $request)
    {
        (new Store())->run($request->all());

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param $countryId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($countryId)
    {
        $country = Country::translate()->findOrFail($countryId);

        return $this->response->ok($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryRequest $request
     * @param $countryId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CountryRequest $request, $countryId)
    {
        $code = $request->get('code');
        $translations = $request->get('translations');

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

        return $this->response->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $countryId
     *
     * @return \Illuminate\Http\JsonResponse
     * @internal param $id
     *
     */
    public function destroy($countryId)
    {
        Country::findOrFail($countryId)->delete();

        return $this->response->noContent();
    }
}
