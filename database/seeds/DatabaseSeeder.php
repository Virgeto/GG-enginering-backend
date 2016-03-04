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

        }

        // Enable mass assignment and foreign key protection.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();

    }
}
