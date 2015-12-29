<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


abstract class Base extends Model
{

    /**
     * Add sorting to the query.
     *
     * @param $query
     * @param $sort
     * @return mixed
     */
    public function scopeSort($query, $sort)
    {
        if (empty($sort)) {
            return $query;
        }

        $sign = substr($sort, 0, 1);
        $field = substr($sort, 0);
        $direction = 'asc';

        if ($sign == '-') {
            $direction = 'desc';
            $field = substr($sort, 1);
        }

        return $query->orderBy($field, $direction);
    }
}
