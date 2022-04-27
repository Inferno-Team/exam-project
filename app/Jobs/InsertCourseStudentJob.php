<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\StudentCourses;
use App\Models\StudentStatus;
use App\Models\StudentYear;
use App\Models\Year;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertCourseStudentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected Course $course;
    protected Int $yearId;
    public function __construct(Course $course, Int $yearId)
    {
        $this->course = $course->withoutRelations();
        $this->yearId = $yearId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $studentsCount = 0;
        $lastYear = Year::orderBy('id', 'desc')->first();
        for ($i = $lastYear->id; $i >= $this->yearId; $i--) {
            // get students
            $sy = StudentYear::where('year_id', $i)->with('student')->get();

            foreach ($sy as $s) {
                $sc = StudentCourses::create([
                    'student_id' => $s->student->id,
                    'course_id' => $this->course->id,
                    'status' => 'اول مرة',
                    
                ]);
                $studentsCount++;
            }
            // $studentsCount += count($sy);
        }
    }
}
