<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['عادي', 'اختياري']);
            $table->foreignId('section_id')->references('id')->on('sections');
            $table->enum('selection_type', [
                'مجموعة 1',
                'مجموعة 2',
                'مجموعة 3',
                'مجموعة 4',
                'مجموعة 5',
            ])->nullable();
            $table->foreignId('sy_id')->references('id')->on('year_semesters');
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
        Schema::dropIfExists('courses');
    }
}
