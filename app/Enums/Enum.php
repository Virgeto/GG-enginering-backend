<?php


namespace App\Enums;

use League\Flysystem\NotSupportedException;
use ReflectionClass;


abstract class Enum
{
    const NONE = null;

    final private function __construct()
    {
        throw new NotSupportedException();
    }

    final private function __clone()
    {
        throw new NotSupportedException();
    }

    /**
     * Get all constants as array.
     *
     * @return array
     */
    final public static function toArray()
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Check if given value is valid constant.
     *
     * @param $value
     * @return bool
     */
    final public static function isValid($value)
    {
        return in_array($value, static::toArray());
    }

}