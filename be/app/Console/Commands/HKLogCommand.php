<?php

namespace App\Console\Commands;

use App\Models\System\LogUserModel;
use App\Models\System\ScheduleResultModel;
use Illuminate\Console\Command;

class HKLogCommand extends Command
{
    protected $signature = 'app:housekeeping-log
                            {tag : user, schedule}
                            {--hours=730 : hour housekeeping data}';
    
    protected $description = 'housekeeping log user application';
    
    public function handle(): int
    {
        $tag = $this->argument('tag');
        $hour = $this->option('hours');

        $query = null;
        if($tag == "user")
        {
            $query = LogUserModel::whereRaw("created_at < now() - interval $hour hour");
        }
        else if ($tag == "schedule")
        {
            $query = ScheduleResultModel::whereRaw("run_at < now() - interval $hour hour");
        }

        if($query == null) {
            $this->warn("tag tidak ditemukan, pastikan tag bernilai user atau schedule");
            return 0;
        }

        $total = $query->count();
        $query->delete();
        $this->info("delete $total result");
        return 1;
    }
}
