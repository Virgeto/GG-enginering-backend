<?php


namespace App;


class CategoryImage extends Base
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get image url.
     *
     * @param  string $name
     * @return string
     */
    public function getNameAttribute($name)
    {
        if (!empty($name)) {
            return url('images/categories/' . $this->category->id . '/' . $name);
        }

        return $name;
    }

    /**
     * Category that current image belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
