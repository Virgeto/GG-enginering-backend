<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddCountryIdToCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedInteger('country_id')
                ->nullable()
                ->after('id');

            $table->index(['country_id']);

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
        if (Schema::hasTable('cities')) {
            Schema::table('cities', function (Blueprint $table) {

                $table->dropForeign('cities_country_id_foreign');
                $table->dropColumn('country_id');

            });
        }

    }
}
