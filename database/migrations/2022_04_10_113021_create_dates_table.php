<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('first_tirm_start')->nullable();
            $table->bigInteger('first_tirm_end')->nullable();
            $table->bigInteger('first_tirm_exam_end')->nullable();

            $table->bigInteger('second_tirm_start')->nullable();
            $table->bigInteger('second_tirm_end')->nullable();
            $table->bigInteger('second_tirm_exam_end')->nullable();

            $table->bigInteger('next_year_first_tirm_start')->nullable();

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
        Schema::dropIfExists('dates');
    }
}
