<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');
            $table->string('name', 100);
            $table->string('lang', 2);
            $table->timestamps();

            $table->index(['city_id', 'lang']);

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
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
        if (Schema::hasTable('city_translations')) {

            Schema::table('city_translations', function ($table) {
                $table->dropForeign('city_translations_city_id_foreign');
            });

            Schema::drop('city_translations');

        }
    }
}
