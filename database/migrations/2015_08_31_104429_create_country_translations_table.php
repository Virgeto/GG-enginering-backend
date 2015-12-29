<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->string('name', 100);
            $table->string('lang', 2);
            $table->timestamps();

            $table->index(['country_id', 'lang']);

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
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
        if (Schema::hasTable('country_translations')) {

            Schema::table('country_translations', function ($table) {
                $table->dropForeign('country_translations_country_id_foreign');
            });

            Schema::drop('country_translations');

        }
    }
}
