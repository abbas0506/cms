<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnloadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unloaders', function (Blueprint $table) {
           $table->increments('id');
            $table->string('name',50);
            $table->string('phone',11)->nullable();
            $table->string('address',100)->nullable();
            $table->unsignedInteger('salary')->default(0);
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
        Schema::dropIfExists('unloaders');
    }
}
