<?php


namespace App\Queries\User;

use App\User;
use App\Libraries\Profile;
use Illuminate\Support\Facades\DB;


class Update
{

    public function run($input, $userId, $role, $hasProfile)
    {
        $input['password'] = bcrypt($input['password']);

        DB::beginTransaction();

        $user = User::findOrFail($userId);
        $user->update($input);

        if ($hasProfile) {
            $profileData = $input['profile'];

            (new Profile())->update($user->profile->id, $profileData, $role);
        }

        DB::commit();
    }


}