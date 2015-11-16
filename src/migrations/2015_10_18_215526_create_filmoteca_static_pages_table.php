<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFilmotecaStaticPagesTable
 */
class CreateFilmotecaStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmoteca_static_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('content');
            $table->string('status', 20);
            $table->integer('parent_page_id')->unsigned()->nullable(true);
            $table->string('slug')->unique();
            $table->timestamps();

            $table
                ->foreign('parent_page_id')
                ->references('id')
                ->on('filmoteca_static_pages')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filmoteca_static_pages');
    }
}
