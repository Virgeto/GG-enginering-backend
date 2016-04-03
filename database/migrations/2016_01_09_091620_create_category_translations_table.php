<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('lang', 2);
            $table->string('name', 200);
            $table->text('text');
            $table->string('slug', 200);
            $table->timestamps();

            $table->index(['category_id', 'lang']);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('category_translations')) {

            Schema::table('category_translations', function ($table) {
                $table->dropForeign('category_translations_category_id_foreign');
            });

            Schema::drop('category_translations');
        }
    }
}
