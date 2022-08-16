<?php

namespace App\Jobs;

use App\Models\StudentCourses;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertStudentMark2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $students;
    private $course_id;
    public function __construct($students,  $course_id)
    {
        $this->students = $students;
        $this->course_id = $course_id;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = 0;
        $passedCount = 0;
        $fieldCount = 0;
        $studentCourse = StudentCourses::where('course_id', $this->course_id)->with('student')->get();
        foreach ($studentCourse as $sc) {
            foreach ($this->students as $student) {
                if ($sc->student->univ_id == $student['univ_id']) {
                    $sc->mark2 = $student['mark2'];
                    $sc->status = $student['fullMark'] >= 60 ? 'ناجح' : 'راسب';
                    $sc->save();
                    $count++;
                    if ($student['fullMark'] >= 60) {
                        $passedCount++;
                    } else {
                        $fieldCount++;
                    }
                }
            }
        }
        info("course mark2 effected : $count");
        info("course mark2 passed count : $passedCount");
        info("course mark2 field count : $fieldCount");
    }
}
