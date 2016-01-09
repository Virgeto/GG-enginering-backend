<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCategoryClosuresTable extends Migration
{
    public function up()
    {
        Schema::create('category_closure', function (Blueprint $table) {
            $table->increments('closure_id');

            $table->unsignedInteger('ancestor');
            $table->unsignedInteger('descendant');
            $table->unsignedInteger('depth');

            $table->foreign('ancestor')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('descendant')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('category_closure', function (Blueprint $table) {
            Schema::dropIfExists('category_closure');
        });
    }
}
