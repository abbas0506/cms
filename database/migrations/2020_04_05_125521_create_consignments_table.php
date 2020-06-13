<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->id();
            $table->integer('biltyNo')->default(0);
            $table->unsignedInteger('containerId');
            $table->unsignedInteger('consignerId');
            $table->unsignedInteger('consigneeId');
            $table->unsignedInteger('nItems');
            $table->string('description',100)->nullable();
            
            $table->unsignedInteger('vehicleCharges')->default(0);
            $table->unsignedInteger('loadOneCharges')->default(0);
            $table->unsignedInteger('biltyOneCharges')->default(0);
            $table->unsignedInteger('insurance')->default(0);
            $table->unsignedInteger('cartOneCharges')->default(0);
            $table->unsignedInteger('otherCharges')->default(0);
            
            $table->unsignedInteger('unloadCharges')->default(0);
            $table->unsignedInteger('biltyTwoCharges')->default(0);
            $table->unsignedInteger('cartTwoCharges')->default(0);
            $table->unsignedInteger('loadTwoCharges')->default(0);
            
            $table->string('receiverName',50)->nullable();
            $table->string('receiverPic',50)->nullable();
            $table->date('receiveDate')->nullable();
            $table->time('receiveTime')->nullable();

            $table->foreign('containerId')
                ->references('id')
                ->on('containers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('consignerId')
                ->references('id')
                ->on('consigners')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('consigneeId')
                ->references('id')
                ->on('consignees')
                ->onUpdate('cascade')
                ->onDelete('cascade');


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
        Schema::dropIfExists('consignments');
    }
}
