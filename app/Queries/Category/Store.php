<?php


namespace App\Queries\Category;

use App\Category;
use Illuminate\Support\Facades\DB;


class Store
{

    /**
     * @var
     */
    private $parentId;

    /**
     * @var
     */
    private $translations;

    /**
     * @param $parentId
     * @param $translations
     */
    public function __construct($parentId, $translations)
    {
        $this->parentId = $parentId;
        $this->translations = $translations;
    }

    public function run()
    {
        DB::beginTransaction();

        $category = new Category();
        $category->save();

        foreach ($this->translations as $fields) {
            $category->translations()->create($fields);
        }

        if (!empty($this->parentId)) {
            $parent = Category::find($this->parentId);
            $parent->addChild($category);
        }

        DB::commit();
    }
}