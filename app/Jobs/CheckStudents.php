<?php

namespace App\Jobs;

use App\Models\Dates;
use App\Models\NationalExamNominee;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStudents implements ShouldQueue
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
        // check for nation exam nomenee
        $dates = Dates::first();
        if ($dates == null) return;
        $tirm = null;
        $thisTime  = round(microtime(true) * 1000);
        info($thisTime);
        if (
            $thisTime >= $dates->first_tirm_start &&
            $thisTime <= $dates->first_tirm_end
        ) {
            $tirm = 'first';
        } else  if (
            $thisTime >= $dates->second_tirm_start &&
            $thisTime <= $dates->second_tirm_end
        ) {
            $tirm = 'second';
        } else  if (
            $thisTime >= $dates->second_tirm_end &&
            $thisTime <= $dates->next_year_first_tirm_start
        ) {
            $tirm = 'final_exam';
        }
        info($tirm);
        if ($tirm == 'frist') {
        } else if ($tirm != 'second') {
        } else if ($tirm == 'final_exam') {
            // check fifth year students for national exam
            $students = Student::whereHas('year', function ($query) {
                $query
                    ->where('year_id', '5');
            })
            
            ->with('courses')->get();
            $old = NationalExamNominee::all();
            $needToDelete = [];
            foreach ($old as $student) {
                foreach ($students as $std) {
                    if ($student->student_id == $std->id) {
                        array_push($needToDelete, $student->student_id);
                    }
                }
            }
            info('conflicts number is :' . count($needToDelete));

            info(count($old));
            info(count($students));
            foreach ($students as $student) {
                if (in_array($student->id, $needToDelete))
                    continue;
                    
                $courses = $student->courses;
                $fieldCourseCounter = 0;
                foreach ($courses as $course) {
                    if ($course->status == 'راسب' || $course->status == 'اول مرة')
                        $fieldCourseCounter++;
                    if ($fieldCourseCounter > 4)
                        break;
                }
                if ($fieldCourseCounter <= 4) {
                    $national = NationalExamNominee::create([
                        'type' => 'عام تخرج',
                        'student_id' => $student->id
                    ]);
                    info($student->name . '  ' .
                        $student->univ_id .
                        ' is Nomineeted to national exam with type : '
                        . $national->type);
                }
            }
        } else {
            // this holiday
        }
    }
}
