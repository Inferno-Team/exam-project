<?php

namespace App\Jobs;

use App\Models\Dates;
use App\Models\Student;
use App\Models\StudentCourses;
use App\Models\StudentStatus;
use App\Models\StudentYear;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStudentStatus implements ShouldQueue
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
        $date = Dates::first();

        if (!isset($date))
            return;
        else {
            $current = $date->current;
            switch ($current) {
                case 'spring-holiday':
                case 'summer-holiday': {
                        $now = Carbon::now();
                        $year =  $now->year;
                        // check student courses [marks]
                        $sutdentsCourses = Student::with('courses', 'year')->get();
                        foreach ($sutdentsCourses as  $student) {
                            if ($student->year->year_id == 5) continue;
                            $courses  = $student->courses;
                            $fieldCourseCounter = 0;
                            foreach ($courses as $course) {
                                if ($course->status == 'راسب' || $course->status == 'اول مرة')
                                    $fieldCourseCounter++;
                                if ($fieldCourseCounter > 4)
                                    break;
                            }
                            $status = 'منقول';
                            $year_id = $student->year->year_id;
                            if ($fieldCourseCounter <= 4) {
                                if ($fieldCourseCounter == 0)
                                    $status = 'ناجح';
                                $year_id++;
                            } else
                                $status = 'راسب';

                            StudentStatus::create([
                                'student_id' => $student->id,
                                'status' => $status,
                                'year_id' => $year_id,
                                'year_date' => ($year - 1) . "/" . $year
                            ]);
                            
                            $studentYear = StudentYear::where('student_id', $student->id)->first();
                            $studentYear->year_id = $year_id;
                            $studentYear->save();
                            $this->dispatch(new InsertCourseToStudent($student, $year_id));
                        }
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
