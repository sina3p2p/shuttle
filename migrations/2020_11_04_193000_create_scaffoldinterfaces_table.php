<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaffoldinterfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuttle_scaffold_interfaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('iconsmind-Bread');
            $table->string('slug');
            $table->string('display_name_singular');
            $table->string('display_name_plural');
            $table->string('migration')->nullable();
            $table->string('model')->nullable();
            $table->string('translation_model')->nullable();
            $table->string('controller')->nullable();
            $table->boolean('menuable')->default(false);
            $table->boolean('by_shuttle')->default(false);
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
        Schema::dropIfExists('shuttle_scaffold_interfaces');
    }
}
