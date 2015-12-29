<?php


use App\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\User;
use App\City;
use App\CityTranslation;
use App\Country;
use App\CountryTranslation;
use Faker\Factory as Faker;


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

        // Development Seeders and Factories.
        if (env('APP_ENV') == 'local') {
            $this->membersFaker(50);
            $this->countriesFaker(5);
            $this->citiesFaker(10);
        }

        // Enable mass assignment and foreign key protection.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();

    }

    /**
     * Uses Faker to fill countries and country_translations tables.
     *
     * @param $count
     */
    private function countriesFaker($count)
    {
        Country::truncate();
        CountryTranslation::truncate();

        factory(Country::class, $count)
            ->create()
            ->each(function ($country) {
                $bgFaker = Faker::create('bg_BG');
                $enFaker = Faker::create();

                $factories = [
                    factory(CountryTranslation::class)->make([
                        'lang' => 'bg',
                        'name' => $bgFaker->country
                    ]),
                    factory(CountryTranslation::class)->make([
                        'lang' => 'en',
                        'name' => $enFaker->country
                    ])
                ];

                $country->code = $enFaker->countryCode;
                $country->save();
                $country->translations()->saveMany($factories);
            });
    }

    /**
     * Uses Faker to fill cities and city_translations tables.
     *
     * @param int $count
     */
    private function citiesFaker($count)
    {
        City::truncate();
        CityTranslation::truncate();

        factory(City::class, $count)
            ->create([
                'country_id' => Country::orderByRaw('RAND()')->first()->id
            ])
            ->each(function ($city) {

                $bgFaker = Faker::create('bg_BG');
                $enFaker = Faker::create();

                $factories = [
                    factory(CityTranslation::class)->make([
                        'lang' => 'bg',
                        'name' => $bgFaker->city
                    ]),
                    factory(CityTranslation::class)->make([
                        'lang' => 'en',
                        'name' => $enFaker->city
                    ])
                ];

                $city->translations()->saveMany($factories);

            });
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
