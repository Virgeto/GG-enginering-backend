<?php


use Illuminate\Database\Seeder;
use App\User;
use App\Role;


class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $owners = [
            [
                'email' => 'admin@email.com',
                'password' => bcrypt('admin')
            ]
        ];

        User::truncate();

        foreach ($owners as $owner) {
            $user = User::create($owner);
            $user->roles()->attach(Role::where('name', 'owner')->firstOrFail());
            $user->save();
        }

    }
}
