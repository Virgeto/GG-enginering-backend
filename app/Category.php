<?php


namespace App;

use Franzose\ClosureTable\Models\Entity;


class Category extends Entity implements CategoryInterface
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * ClosureTable model instance.
     *
     * @var categoryClosure
     */
    protected $closure = CategoryClosure::class;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get translation for current language.
     *
     * @return mixed
     */
    public function translation()
    {
        return $this->hasOne(CategoryTranslation::class)->where('lang', app()->getLocale());
    }

    /**
     * Translations related to current Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    /**
     * Upload category icon and save its name into database.
     *
     * @param $icon
     */
    public function saveIcon($icon)
    {
        $path = public_path('images/categories/' . $this->id . '/icon');
        $filename = $icon->getClientOriginalName();
        $icon->move($path, $filename);

        $this->icon = $filename;
        $this->save();
    }
}
