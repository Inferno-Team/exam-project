<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourses;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertStudentsMarks implements ShouldQueue
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
        $students = Student::with('year')->get();
        $courses = Course::with('year_semester')->get();
        foreach ($courses as $course) {
            for ($i = 0; $i < count($students); $i++) {
                $std = $students[$i];
                if ($course->year_semester->year_id <= $std->year->year_id) {
                    $mark1 = rand(12, 30);
                    $mark2 = rand(30, 70);
                    $fullmark = $mark1 + $mark2;
                    $status = '';
                    if ($fullmark >= 60) $status = 'ناجح';
                    else $status = 'راسب';
                    $sc = StudentCourses::create([
                        'student_id' => $std->id,
                        'course_id' => $course->id,
                        'status' => $status,
                        'mark1' => $mark1,
                        'mark2' => $mark2
                    ]);
                    info($sc);
                }
            }
        }
    }
}
