<?php


use App\Category;
use App\CategoryTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        CategoryTranslation::truncate();
        DB::table('category_closure')->truncate();
    }
}
