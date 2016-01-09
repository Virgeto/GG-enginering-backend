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
    protected $closure = 'App\CategoryClosure';

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
}
