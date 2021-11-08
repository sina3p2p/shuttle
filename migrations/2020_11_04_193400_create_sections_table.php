<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuttle_sections', function (Blueprint $table) {
            $table->id();
//            $table->string('url')->nullable();
//            $table->boolean('breadcrumb')->default(false);
            $table->json('model')->nullable();
            $table->integer('position')->default(0);
            $table->bigInteger('type_id')->unsigned()->default(0);
            $table->foreign('type_id')->references('id')->on('shuttle_types')->onDelete('cascade');
            $table->longText('body')->nullable();
            $table->timestamps();
        });

//        Schema::create('section_translations', function (Blueprint $table) {
//            $table->id();
//            $table->string('locale')->index();
//            $table->bigInteger('section_id')->unsigned();
//            $table->unique(['section_id', 'locale']);
//            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
//            // add here your respective model attributes
//            // which you want to be translated
//            $table->string('title')->nullable();
//            $table->string('keyword')->nullable();
//            $table->string('description')->nullable();
//            $table->string('image')->nullable();
//            $table->longText('body')->nullable();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shuttle_sections');
//        Schema::dropIfExists('section_translations');
    }
}
