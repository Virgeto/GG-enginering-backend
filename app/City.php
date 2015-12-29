<?php


namespace App;


class City extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * Fields that will not be shown in response.
     *
     * @var array
     */
    protected $hidden = [
        'city_id',
        'country_id'
    ];

    /**
     * Get translation for current language.
     *
     * @return mixed
     */
    public function translation()
    {
        return $this->hasOne(CityTranslation::class)->where('lang', app()->getLocale());
    }

    /**
     * Translations related to the City.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany('App\CityTranslation');
    }

    /**
     * Country that is related to the City.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
