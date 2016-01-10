<?php


namespace App\Queries\Category;

use App\Category;


class Show extends Query
{

    /**
     * @var
     */
    private $categoryId;

    /**
     * @param $categoryId
     */
    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function run()
    {
        $children = Category::findOrFail($this->categoryId)
            ->getChildren();
        $children = $this->addTranslation($children);

        return $children;
    }
}