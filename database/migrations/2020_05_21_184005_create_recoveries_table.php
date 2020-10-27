<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recoveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('consigneeId');
            $table->unsignedInteger('amount');
            $table->string('description', 100)->nullable();
            $table->unsignedInteger('batchId');

            $table->foreign('consigneeId')
                ->references('id')
                ->on('consignees')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('batchId')
                ->references('id')
                ->on('batches')
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
        Schema::dropIfExists('recoveries');
    }
}
