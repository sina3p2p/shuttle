<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('admin');
            $table->rememberToken();
            $table->timestamps();
        });

        \Sina\Shuttle\Models\Admin::create([
            'name'       => 'Sina',
            'email'      => 'sinaparsa9991@yahoo.com',
            'role'       => 'developer',
            'password'   => bcrypt('admin123'),
        ]);

        \Sina\Shuttle\Models\Admin::create([
            'name'       => 'Nika',
            'email'      => 'nika@mygo.ge',
            'role'       => 'developer',
            'password'   => bcrypt('admin123'),
        ]);

        \Sina\Shuttle\Models\Admin::create([
            'name'       => 'Dea',
            'email'      => 'dea@mygo.ge',
            'role'       => 'developer',
            'password'   => bcrypt('admin123'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
