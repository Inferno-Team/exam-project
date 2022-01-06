<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_extras', function (Blueprint $table) {
            $table->id();
            $table->enum('name',['عقوبة','مكافئة']);
            $table->string('value');
            $table->foreignId('student_id')->references('id')->on('students');
            $table->foreignId('year_id')->references('id')->on('years');
            
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
        Schema::dropIfExists('student_extras');
    }
}
