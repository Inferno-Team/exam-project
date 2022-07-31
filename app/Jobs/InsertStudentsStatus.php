<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\StudentYear;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class InsertStudentsStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sy = StudentYear::get();
        $finalDate = 2022;
        $type = 'منقول';
        for ($i = 0; $i < count($sy); $i++) {
            $year_id = $sy[$i]->year_id;
            $student_id = $sy[$i]->student_id;
            $date = rand(2012, 2021); // date =2014 & year_id = 3 => 2017 ,, z = 5 year fields
            if ($date + $year_id < $finalDate) {
                $z = $finalDate - ($date + $year_id);
                for ($k = 0; $k < $z; $k++) {
                    $fYId = rand(1, $year_id); // field year id
                    $fDate = $date + ($fYId - 1) + $z;
                    DB::table('student_status')->insert([
                        'student_id' => $student_id,
                        'year_id' => $fYId,
                        'status' => 'راسب',
                        'year_date' => "$fDate/" . ($fDate + 1)
                    ]);
                }
            } else {
                for ($j = 1; $j <= $year_id; $j++) {
                    $typeId = rand(1, 2);
                    if ($typeId == 1) $type = 'منقول';
                    else  $type = 'ناجح';
                    DB::table('student_status')->insert([
                        'student_id' => $student_id,
                        'year_id' => $j,
                        'status' => $type,
                        'year_date' => "$date/" . ($date + 1)
                    ]);
                }
            }
        }
    }
}
