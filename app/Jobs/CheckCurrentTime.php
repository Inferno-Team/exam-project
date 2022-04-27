<?php

namespace App\Jobs;

use App\Models\Dates;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckCurrentTime implements ShouldQueue
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
        if (!isset($date)) return;
        // checking time status ...
        $thisTime  = round(microtime(true) * 1000);
        if ($thisTime > $date->first_tirm_start && $thisTime < $date->first_tirm_end)
            $date->current = 'first-tirm';
        else if ($thisTime > $date->first_tirm_end && $thisTime < $date->first_tirm_exam_end)
            $date->current = 'first-tirm-exam';
        else if ($thisTime > $date->first_tirm_exam_end && $thisTime < $date->second_tirm_start)
            $date->current = 'spring-holiday';
        else if ($thisTime > $date->second_tirm_start && $thisTime < $date->second_tirm_end)
            $date->current = 'second-tirm';
        else if ($thisTime > $date->second_tirm_end && $thisTime < $date->second_tirm_exam_end)
            $date->current = 'final-exam';
        else if ($thisTime > $date->second_tirm_exam_end && $thisTime < $date->next_year_first_tirm_start)
            $date->current = 'summer-holiday';

        $date->save();
    }
}
