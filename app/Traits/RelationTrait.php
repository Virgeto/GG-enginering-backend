<?php


namespace App\Traits;


trait RelationTrait
{
    /**
     * Add each relation as executing predefined methods in the Model that
     * uses this trait. For example:
     *
     * $relations = ['cities', 'stations'];
     *
     * Executed methods will be "withCities" and "withStations". Where "with"
     * is a prefix and "cities"/"stations" are relations with capitalized
     * first letter.
     *
     * @param $query
     * @param $relations
     * @param string $prefix
     * @return mixed
     */
    public function scopeWithRelations($query, $relations, $prefix = 'with')
    {
        $relations = explode(',', $relations);

        $result = [];
        foreach ($relations as $relation) {
            if (!empty($relation)) {
                $functionName = $prefix . ucfirst($relation);

                if (method_exists($this, $functionName)) {
                    $result[$relation] = $this->$functionName();
                } else {
                    $result[] = $relation;
                }

            }
        }

        return $query->with($result);
    }
}