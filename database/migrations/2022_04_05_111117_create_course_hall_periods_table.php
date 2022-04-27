<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseHallPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_hall_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->references("id")->on("courses");
            $table->foreignId("period_id")->references("id")->on("periods");
            $table->foreignId("hall_id")->references("id")->on("halls");
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
        Schema::dropIfExists('course_hall_periods');
    }
}
