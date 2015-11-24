<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmotecaMenuEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmoteca_menu_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label')->nullable(false);
            $table->string('url')->nullable(false);
            $table->integer('position', false, true)->default(0);
            $table->integer('menu_id', false, true);
            $table->timestamps();

            $table->unique(['label', 'url', 'menu_id']);

            $table->foreign('menu_id')
                ->references('id')
                ->on('filmoteca_menus')
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
        Schema::drop('filmoteca_menu_entries');
    }

}
