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
     * @var
     */
    private $icon;

    /**
     * @param $parentId
     * @param $translations
     * @param $icon
     */
    public function __construct($parentId, $translations, $icon)
    {
        $this->parentId = $parentId;
        $this->translations = $translations;
        $this->icon = $icon;
    }

    public function run()
    {
        DB::beginTransaction();

        $category = new Category();
        $category->save();
        $category->saveIcon($this->icon);

        foreach ($this->translations as $fields) {
            $fields['slug'] = slug($fields['name']);
            $category->translations()->create($fields);
        }

        if (!empty($this->parentId)) {
            $parent = Category::find($this->parentId);
            $parent->addChild($category);
        }

        DB::commit();
    }
}