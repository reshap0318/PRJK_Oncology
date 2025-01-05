<?php

namespace Database\Seeders;

use App\Models\System\ScheduleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'schedule' => [
                    'description'           => "Housekeeping Log Schedule",
                    'command'               => "app:housekeeping-log",
                    'parameters'            => "schedule",
                    'timezone'              => "Asia/Jakarta",
                    'is_active'             => 1
                ],
                'frequency'=> [
                    'interval'  => 'dailyAt',
                    'param_1'   => '00:01'
                ],
                'result'   => [
                    'duration'  => 0,
                    'result'    => 'initial housekeeping',
                ],
            ],
            [
                'schedule' => [
                    'description'           => "Housekeeping Log User",
                    'command'               => "app:housekeeping-log",
                    'parameters'            => "user",
                    'timezone'              => "Asia/Jakarta",
                    'is_active'             => 1
                ],
                'frequency'=> [
                    'interval'  => 'dailyAt',
                    'param_1'   => '00:06'
                ],
                'result'   => [
                    'duration'  => 0,
                    'result'    => 'initial housekeeping',
                ],
            ],
        ];

        foreach ($datas as $item) {
            $schedule = ScheduleModel::create($item['schedule']);
    
            $schedule->frequencies()->create($item['frequency']);
    
            $schedule->results()->create($item['result']);
        }
    }
}
