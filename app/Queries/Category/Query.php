<?php


namespace App\Queries\Category;


class Query
{

    /**
     * Add translation for each Item from collection.
     *
     * @param $items
     * @return mixed
     */
    protected function addTranslation($items)
    {
        foreach ($items as $item) {
            $item->translation;
        }

        return $items;
    }
}