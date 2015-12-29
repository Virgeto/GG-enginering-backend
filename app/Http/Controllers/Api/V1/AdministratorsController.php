<?php


namespace App\Http\Controllers\Api\V1;

use App\User;
use App\Queries\User\Store;
use App\Queries\User\Update;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdministratorRequest;


class AdministratorsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AdministratorRequest $request)
    {
        $administrators = User::whereHasRole('administrator')->paginate(getPerPage());

        return $this->response->ok($administrators);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdministratorRequest $request)
    {
        $input = $request->only(['email', 'password']);

        (new Store())->run($input, 'administrator', false);

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param AdministratorRequest $request
     * @param $administratorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AdministratorRequest $request, $administratorId)
    {
        $administrator = User::whereHasRole('administrator')->findOrFail($administratorId);

        return $this->response->ok($administrator);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdministratorRequest $request
     * @param $administratorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdministratorRequest $request, $administratorId)
    {
        $input = $request->only(['email', 'password']);

        (new Update())->run($input, $administratorId, 'administrator', false);

        return $this->response->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AdministratorRequest $request
     * @param $administratorId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AdministratorRequest $request, $administratorId)
    {
        User::whereHasRole('administrator')
            ->findOrFail($administratorId)
            ->delete();

        return $this->response->noContent();
    }
}
