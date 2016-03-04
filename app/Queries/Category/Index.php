<?php


namespace App\Queries\Category;

use App\Category;


class Index extends Query
{

    public function run()
    {
        $categories = Category::getRoots();
        $categories->load('translation');

        return $categories;
    }
}