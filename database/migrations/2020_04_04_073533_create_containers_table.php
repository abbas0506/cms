<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forwarderId')->unsigned();
            $table->string('vehicleNo',10);
            $table->string('carrierName',50);
            $table->string('carrierPhone',11)->nullable();
            $table->integer('commission')->unsigned();
            $table->timestamps();
                        
            $table->foreign('forwarderId')
                ->references('id')
                ->on('forwarders')
                ->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('containers');
    }
}
