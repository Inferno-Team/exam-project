<?php

use App\Models\Semester;
use App\Models\Year;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateYearSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->references('id')->on('years');
            $table->foreignId('semester_id')->references('id')->on('semesters');
            $table->string('name')->default('');
            $table->timestamps();
        });
        $years = Year::all();
        $semesters = Semester::all();
        foreach ($years as $y) {
            foreach ($semesters as $s) {
                if ($y->id != 5 && $s->name == 'تكميلي')
                    continue;
                DB::table('year_semesters')->insert([
                    'year_id' => $y->id,
                    'semester_id' => $s->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_semesters');
    }
}
