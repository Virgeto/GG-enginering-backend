<?php


namespace App\Queries\User;

use App\Role;
use App\User;
use App\Libraries\Profile;
use Illuminate\Support\Facades\DB;


class Store
{
    public function run($input, $role, $hasProfile)
    {
        $input['password'] = bcrypt($input['password']);
        $profile = null;

        DB::beginTransaction();

        if ($hasProfile) {
            $profileData = $input['profile'];

            $profile = (new Profile())->create($profileData, $role);
        }

        $user = User::create($input);
        $user->associateProfile($profile);
        $user->roles()->attach(Role::where('name', $role)->firstOrFail());
        $user->save();

        DB::commit();
    }
}