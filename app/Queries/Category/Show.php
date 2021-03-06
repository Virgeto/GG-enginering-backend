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
     * @var
     */
    private $relations;

    /**
     * @param $categoryId
     * @param $input
     */
    public function __construct($categoryId, $input)
    {
        $this->categoryId = $categoryId;
        $this->relations = $input['with'];
    }

    public function run()
    {
        $category = Category::withRelations($this->relations)
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