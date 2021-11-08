<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuttle_page_component', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_id')->unsigned();
            $table->bigInteger('component_id')->unsigned();
            $table->json('setting')->nullable();
            $table->integer('position')->default(0);
            $table->foreign('page_id')->references('id')->on('shuttle_pages')->onDelete('cascade');
            $table->foreign('component_id')->references('id')->on('shuttle_components')->onDelete('cascade');
            $table->string('locale')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shuttle_page_component');
    }
}
