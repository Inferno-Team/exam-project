<?php

use App\Models\Student;
use App\Models\StudentYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDumyDataIntoStudentHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $students = StudentYear::get();
        foreach ($students as $s) {
            switch ($s->year_id) {
                case 1:
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => $s->year_id,
                        'year_date' => '2021/2022',
                    ]);
                    break;
                case 2:
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 1,
                        'year_date' => '2020/2021',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => $s->year_id,
                        'year_date' => '2021/2022',
                    ]);
                    break;
                case 3:
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 1,
                        'year_date' => '2018/2019/2020',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 2,
                        'year_date' => '2020/2021',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => $s->year_id,
                        'year_date' => '2021/2022',
                    ]);
                    break;
                case 4:
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 1,
                        'year_date' => '2017/2018/2019',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 2,
                        'year_date' => '2019/2020',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 3,
                        'year_date' => '2020/2021',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 4,
                        'year_date' => '2021/2022',
                    ]);
                    break;
                case 5:
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 1,
                        'year_date' => '2016/2017/2018',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 2,
                        'year_date' => '2018/2019',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 3,
                        'year_date' => '2019/2020',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 4,
                        'year_date' => '2020/2021',
                    ]);
                    DB::table('student_years_histories')->insert([
                        'student_id' => $s->student_id,
                        'year_id' => 5,
                        'year_date' => '2021/2022',
                    ]);
                    break;

                default:
                    # code...
                    break;
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
        //
    }
}
