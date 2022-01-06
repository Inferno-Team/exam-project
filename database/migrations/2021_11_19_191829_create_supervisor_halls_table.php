<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisorHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor_halls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')->references('id')->on('supervisors');
            $table->foreignId('hall_id')->references('id')->on('halls');
            $table->foreignId('period_id')->references('id')->on('periods');
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
        Schema::dropIfExists('supervisor_halls');
    }
}
