<?php

namespace App\Jobs;

use App\Models\StudentCourses;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertStudentMark1 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        info($this->students);
        $studentCourse = StudentCourses::where('course_id', $this->course_id)->with('student')->get();
        
        foreach ($studentCourse as $sc) {
            foreach ($this->students as $student) {
                if ($sc->student->univ_id == $student['univ_id']) {
                    $sc->mark1 = $student['fullMark'];
                    $sc->save();
                    $count++;
                }
            }
        }
        info("course mark1 effected : $count");
    }
}
