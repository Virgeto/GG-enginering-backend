<?php


namespace App\Queries\User;

use App\User;
use Illuminate\Support\Facades\DB;


class Delete
{
    public function run($userId)
    {
        DB::beginTransaction();

        $user = User::findOrFail($userId);
        $user->profile()->delete();
        $user->delete();

        DB::commit();
    }
}