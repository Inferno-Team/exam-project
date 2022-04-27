<?php

use App\Models\Student;
use App\Models\StudentYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertStudentStatusDumyData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $students = Student::get();

        for ($i = 0; $i < count($students); $i++) {
            $yearId = rand(1, 5);
            $date = rand(2012, 2022);
            $st = $students[$i];
            StudentYear::create([
                'student_id' => $st->id,
                'year_id' => $yearId,
            ]);
            for ($j = 1; $j <= $yearId; $j++) {
                DB::table('student_status')->insert([
                    'student_id' => $st->id,
                    'year_id' => $j,

                    'status' => 'منقول',
                    'year_date' => "$date/" . ($date + 1)
                ]);
                $date++;
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
