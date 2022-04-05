<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentHallPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_hall_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId("studen_id")->references("id")->on("students");
            $table->foreignId("hall_id")->references("id")->on("halls");
            $table->foreignId("period_id")->references("id")->on("periods");
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
        Schema::dropIfExists('student_hall_periods');
    }
}
