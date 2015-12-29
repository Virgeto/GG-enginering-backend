<?php


namespace App\Libraries;


class Profile
{

    /**
     * Create profile by given role. For example if role is member it will save
     * $input in members table.
     *
     * @param array $input
     * @param string $role
     * @return mixed
     * @throws \Exception
     */
    public function create($input, $role)
    {
        $profileClass = $this->roleToClass($role);
        $profile = $profileClass::create($input);

        return $profile;
    }

    /**
     * Update profile by given role. For example if role is member it will update
     * members table.
     *
     * @param $profileId
     * @param array $input
     * @param string $role
     * @return mixed
     * @throws \Exception
     */
    public function update($profileId, $input, $role)
    {
        $profileClass = $this->roleToClass($role);
        $profileClass::findOrFail($profileId)->update($input);
    }

    /**
     * Create Class namespace as string from given role.
     *
     * @param $role
     * @return string
     * @throws \Exception
     */
    private function roleToClass($role)
    {
        $profileClass = 'App\\' . ucfirst($role);

        if (!class_exists($profileClass)) {
            throw new \Exception('Profile model ' . $profileClass . ' did not exists.');
        }

        return $profileClass;
    }


}