<?php


namespace App;


class Country extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];

    /**
     * Get translation for current language.
     *
     * @return mixed
     */
    public function translation()
    {
        return $this->hasOne(CountryTranslation::class)->where('lang', app()->getLocale());
    }

    /**
     * Translations related to the Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

    /**
     * Cities related to the Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
