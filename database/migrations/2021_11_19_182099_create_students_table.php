<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('univ_id')->unique();
            $table->string('name');
            $table->string('father_name');
            $table->string('last_name');
            $table->string('mother_name');
            $table->string('birth_place');
            $table->enum('gender', ['ذكر', 'انثى']);
            $table->integer('field_number');
            $table->string('recruitment_division')->nullable();
            $table->string('city');
            $table->string('address');
            $table->string('nationalty');
        
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
        Schema::dropIfExists('students');
    }
}
