<?php


use App\Role;
use App\User;
use App\Member;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Disable mass assignment and foreign key protection.
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Production Seeders
        $this->call(RoleSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(CategorySeeder::class);

        // Development Seeders and Factories.
        if (env('APP_ENV') == 'local') {
            $this->membersFaker(50);
        }

        // Enable mass assignment and foreign key protection.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();

    }

    /**
     * Fill users table with members.
     *
     * @param $count
     */
    private function membersFaker($count)
    {
        Member::truncate();

        $faker = Faker::create();

        factory(Member::class, $count)
            ->make()
            ->each(function ($member) use ($faker) {

                $member->first_name = $faker->firstName;
                $member->last_name = $faker->lastName;
                $member->address = $faker->address;
                $member->save();

                $user = User::create(
                    [
                        'profile_id' => $member->id,
                        'profile_type' => Member::class,
                        'email' => $faker->email,
                        'password' => bcrypt('qweasd')
                    ]
                );

                $user->roles()
                    ->attach(Role::where('name', 'member')->firstOrFail());
            });
    }
}
