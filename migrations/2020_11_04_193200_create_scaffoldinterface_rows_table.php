<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaffoldinterfaceRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shuttle_scaffold_interface_rows', function (Blueprint $table) {
            $table->id();
            // $table->integer('scaffold_interface_id')->unsigned();
            $table->string('rowable_type')->nullable();
            $table->integer('rowable_id')->unsigned();
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('field');
            $table->string('type');
            $table->string('display_name')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('browse')->default(true);
            $table->boolean('read')->default(true);
            $table->boolean('edit')->default(true);
            $table->boolean('add')->default(true);
            $table->boolean('delete')->default(true);
            $table->json('details')->nullable();
            $table->integer('ord')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shuttle_scaffold_interface_rows');
    }
}
