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
        Schema::create('scaffold_interface_rows', function (Blueprint $table) {
            $table->id();
            $table->integer('scaffold_interface_id')->unsigned();
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

            $table->foreign('scaffold_interface_id')->references('id')->on('scaffold_interfaces')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scaffoldinterface_rows');
    }
}
