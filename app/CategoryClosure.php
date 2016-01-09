<?php


namespace App;

use Franzose\ClosureTable\Models\ClosureTable;


class CategoryClosure extends ClosureTable implements CategoryClosureInterface
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_closure';
}
