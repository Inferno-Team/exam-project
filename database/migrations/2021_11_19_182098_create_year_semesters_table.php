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
            $table->integer('year_id');
            $table->string('semester_name');
            $table->timestamps();
        });
        $years = Year::get();
        $semesters = [
            'فصل أول',
            'فصل ثاني',
        ];
        for ($i = 0; $i < count($years); $i++) {
            $year = $years[$i]->id;

            for ($j = 0; $j < count($semesters); $j++) {
               DB::table('year_semesters')->insert([
                'year_id' => $year,
                'semester_name' => $semesters[$j]
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
