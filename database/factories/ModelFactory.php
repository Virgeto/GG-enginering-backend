<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Member;
use App\City;
use App\CityTranslation;
use App\Country;
use App\CountryTranslation;


$factory->define(Member::class, function ($faker) {
    return [];
});

$factory->define(Country::class, function ($faker) {
    return [];
});

$factory->define(CountryTranslation::class, function ($faker) {
    return [];
});

$factory->define(City::class, function ($faker) {
    return [];
});

$factory->define(CityTranslation::class, function ($faker) {
    return [];
});



