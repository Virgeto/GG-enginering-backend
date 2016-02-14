<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreatePageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id');
            $table->text('title');
            $table->text('text');
            $table->timestamps();

            $table->index(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
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
        if (Schema::hasTable('page_translations')) {

            Schema::table('page_translations', function ($table) {
                $table->dropForeign('page_translations_page_id_foreign');
            });

            Schema::drop('page_translations');
        }
    }
}
