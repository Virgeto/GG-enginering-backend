<?php


namespace App\Queries\Category;

use App\Category;


class Index extends Query
{

    public function run()
    {
        $categories = Category::getRoots();
        $categories = $this->addTranslation($categories);

        return $categories;
    }
}