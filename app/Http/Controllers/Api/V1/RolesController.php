<?php


namespace App\Http\Controllers\Api\V1;

use App\Role;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RoleRequest $request)
    {
        $roles = Role::paginate(getPerPage());

        return $this->response->ok($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        Role::create($request->all());

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param RoleRequest $request
     * @param $roleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(RoleRequest $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        return $this->response->ok($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param $roleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, $roleId)
    {
        Role::findOrFail($roleId)->update($request->all());

        return $this->response->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RoleRequest $request
     * @param $roleId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RoleRequest $request, $roleId)
    {
        Role::findOrFail($roleId)->delete();

        return $this->response->noContent();
    }
}
