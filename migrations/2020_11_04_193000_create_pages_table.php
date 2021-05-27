<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('image')->nullable();
            $table->bigInteger('type_id')->unsigned()->default(0);
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('page_id')->unsigned();
            $table->unique(['page_id', 'locale']);
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            // add here your respective model attributes
            // which you want to be translated
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_translations');
    }
}
