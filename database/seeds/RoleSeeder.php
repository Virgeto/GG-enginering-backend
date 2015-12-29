<?php


use App\Role;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'owner'
            ],
            [
                'name' => 'administrator'
            ],
            [
                'name' => 'member'
            ]
        ];

        Role::truncate();

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
