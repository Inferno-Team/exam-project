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

class InsertCourseToStudent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Student $student;
    protected int $yearId;
    public function __construct($student, int $yearId)
    {
        $this->student = $student->withoutRelations();
        $this->yearId = $yearId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // insert new year courses to this student
        $courses = Course::whereHas(
            'year_semester',
            fn ($query) =>
            $query->where('year_id', $this->yearId)
        )->get();
        info($courses);
        foreach ($courses as $course) {
            StudentCourses::create([
                'student_id' => $this->student->id,
                'course_id' => $course->id,
                'status' => 'اول مرة'
            ]);
        }
    }
}
