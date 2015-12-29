<?php


namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use App\User;
use App\Queries\User\Store;
use App\Queries\User\Delete;
use App\Queries\User\Update;
use App\Http\Requests\MemberRequest;
use App\Http\Controllers\Controller;


class MembersController extends Controller
{

    /**
     * Display a listing of the Members.
     *
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(MemberRequest $request)
    {
        $members = User::with('profile')
            ->hasRole('member')
            ->paginate(getPerPage());

        return $this->response->ok($members);
    }

    /**
     * Store a newly created Member in Database.
     *
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MemberRequest $request)
    {
        (new Store())->run($request->all(), 'member', true);

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param MemberRequest $request
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MemberRequest $request, $memberId)
    {
        $member = User::with('profile')
            ->hasRole('member')
            ->findOrFail($memberId);

        return $this->response->ok($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberRequest $request
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MemberRequest $request, $memberId)
    {
        (new Update())->run($request->all(), $memberId, 'member', true);

        return $this->response->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MemberRequest $request
     * @param $memberId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MemberRequest $request, $memberId)
    {
        (new Delete())->run($memberId);

        return $this->response->noContent();
    }

}
