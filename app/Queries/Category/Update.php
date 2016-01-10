<?php


namespace App\Queries\Category;


use App\Category;
use Illuminate\Support\Facades\DB;

class Update
{

    /**
     * @var
     */
    private $categoryId;

    /**
     * @var
     */
    private $parentId;

    /**
     * @var
     */
    private $translations;

    /**
     * @param $categoryId
     * @param $parentId
     * @param $translations
     */
    public function __construct($categoryId, $parentId, $translations)
    {
        $this->categoryId = $categoryId;
        $this->parentId = $parentId;
        $this->translations = $translations;
    }

    public function run()
    {
        DB::beginTransaction();

        $category = Category::findOrFail($this->categoryId);

        foreach ($this->translations as $fields) {
            $category->translations()
                ->where('lang', $fields['lang'])
                ->update(['name' => $fields['name']]);
        }

        if (empty($this->parentId)) {
            $category->makeRoot(0);
        } else {
            $parent = Category::findOrFail($this->parentId);
            $parent->addChild($category);
        }

        DB::commit();
    }
}