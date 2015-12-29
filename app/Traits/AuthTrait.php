<?php


namespace App\Traits;

use JWTAuth;


trait AuthTrait
{

    /**
     * Check if authenticated User has given role.
     *
     * @param array $roles
     * @return bool
     */
    public function hasRoles($roles)
    {
        $role = $this->authUser()
            ->roles()
            ->whereIn('name', $roles)
            ->first();

        if (!empty($role)) {
            return true;
        }

        return false;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function isRequestedUser($userId)
    {
        return $this->authUser()->id = $userId;
    }

    /**
     * Return currently authenticated User.
     *
     * @return mixed
     */
    public function authUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

}