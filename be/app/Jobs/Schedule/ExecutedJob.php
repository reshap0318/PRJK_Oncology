<?php

namespace App\Jobs\Schedule;

use App\Models\ScheduleModel;
use App\Models\System\ScheduleResultModel;
use App\Notifications\Schedule\JobCompletedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExecutedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mainModel, $start, $output;
    
    public function __construct(ScheduleResultModel $mainModel, $start, $output)
    {
        $this->mainModel        = $mainModel;
        $this->start            = $start;
        $this->output           = $output;
    }

    /**
     * Execute the job.
     * dont forget run queue work
     * @return void
     */
    public function handle(): void
    {
        $duration = microtime(true) - ($this->start ?? microtime(true));
        $this->mainModel->update([
            'duration'  => $duration,
            'result'    => $this->output,
        ]);
        
        $this->mainModel->schedule->notify(new JobCompletedNotification($this->output));
    }
}
