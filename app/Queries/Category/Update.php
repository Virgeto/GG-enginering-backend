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
     * @var
     */
    private $icon;

    /**
     * @param $categoryId
     * @param $parentId
     * @param $translations
     */
    public function __construct($categoryId, $parentId, $translations, $icon)
    {
        $this->categoryId = $categoryId;
        $this->parentId = $parentId;
        $this->translations = $translations;
        $this->icon = $icon;
    }

    public function run()
    {
        DB::beginTransaction();

        $category = Category::findOrFail($this->categoryId);
        $category->saveIcon($this->icon);

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