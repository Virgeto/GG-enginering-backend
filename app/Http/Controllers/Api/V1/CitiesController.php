<?php


namespace App\Http\Controllers\Api\V1;

use App\City;
use App\Queries\City\Store;
use App\Queries\City\Update;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;


class CitiesController extends Controller
{

    /**
     * Return list of resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cities = City::translate()->paginate(getPerPage());

        return $this->response->ok($cities);
    }

    /**
     * Store a new resource.
     *
     * @param CityRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CityRequest $request)
    {
        (new Store())->run($request->all());

        return $this->response->created();
    }

    /**
     * Return specific resource.
     *
     * @param $cityId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($cityId)
    {
        $city = City::translate()->findOrFail($cityId);

        return $this->response->ok($city);
    }

    /**
     * Update specific resource.
     *
     * @param CityRequest $request
     * @param $cityId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CityRequest $request, $cityId)
    {
        (new Update())->run($request->all(), $cityId);

        return $this->response->noContent();
    }

    /**
     * Delete specific resource.
     *
     * @param $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($cityId)
    {
        City::findOrFail($cityId)->delete();

        return $this->response->noContent();
    }

}
