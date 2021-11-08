<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuttle_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('shuttle_menu_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pid')->default(0);
            $table->integer('lft')->default(0);
            $table->integer('rgt')->default(0);
            $table->integer('depth')->default(0);
            $table->integer('ord')->default(0);
            $table->integer('menu_id')->default(0);
            $table->morphs('menuable');
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::create('shuttle_menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('menu_item_id')->unsigned();
            $table->unique(['menu_item_id', 'locale']);
            $table->foreign('menu_item_id')->references('id')->on('shuttle_menu_items')->onDelete('cascade');
            $table->string('title')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shuttle_menu_item_translations');
        Schema::dropIfExists('shuttle_menu_items');
        Schema::dropIfExists('shuttle_menus');    
    }
}
