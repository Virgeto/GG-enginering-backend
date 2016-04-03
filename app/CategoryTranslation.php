<?php


namespace App;


class CategoryTranslation extends Base
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lang',
        'name',
        'text',
        'slug'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'category_id',
        'created_at',
        'updated_at'
    ];


}
