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
        $category = Category::with('translation')
            ->findOrFail($this->categoryId);
        $category = $this->addChildren($category);

        return $category;
    }

    /**
     * Add Categories children.
     *
     * @param $category
     * @return mixed
     */
    private function addChildren($category)
    {
        $children = $category->getChildren();
        $children->load('translation');
        $category->children = $children;

        return $category;
    }
}