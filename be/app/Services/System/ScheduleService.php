<?php

namespace App\Services\System;

use App\Helpers\Authorization;
use App\Jobs\Schedule\ExecutedJob;
use App\Repository\System\{
    ScheduleRepository,
    ScheduleFrequencyRepository
};
use App\Services\BaseService;
use Closure;
use Cron\CronExpression;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\ManagesFrequencies;

class ScheduleService extends BaseService
{
    use ManagesFrequencies;
    
    protected $scheduleFrequencyRepository, $mainRepository;
    protected $expression, $timezone, $filters;

    public function __construct() {
        $this->mainRepository = new ScheduleRepository();
        $this->scheduleFrequencyRepository = new ScheduleFrequencyRepository();
    }

    public function getData()
    {
        return $this->mainRepository->getData()->get();
    }

    public function getDataTable()
    {
        $query = $this->mainRepository->getDataTable()->getQuery();

        return DataTables::eloquent($query)
            ->addColumn('last_run', function($data)
            {
                return optional($data->results->last())->run_at ?? '-';
            })
            ->addColumn('next_run', function($data)
            {
                return getUpComingCron($this->getCronExpression($data));
            })
            ->addColumn('action', function($data)
            {
                return [
                    'detail' => [
                        'isCan' => Authorization::hasPermission('schedule.show'),
                        'link'  => route('schedule.data', ['id' => $data]),
                    ]
                ];
            })
            ->make(true);
    }

    public function getById($id)
    {
        $data = $this->mainRepository->getById($id)->first();
        abort_if(!$data, 404, __('messages.404'));
        $data->action = $data->actionModel;
        $data->next_run = CronExpression::factory($this->getCronExpression($data))->getNextRunDate()->format('Y-m-d H:i:s');
        return $data;
    }

    public function create($data)
    {
        $data = collect($data);
        $schedule = $data->except('frequencies')->toArray();
        $res = $this->mainRepository->create($schedule);

        $frequency = array_map(function($d) use ($res)
        {
            return [
                'schedule_id'   => $res->id, 
                'interval'      => $d['interval'],
                'param_1'       => $d['param_1'] ?? null, 
                'param_2'       => $d['param_2'] ?? null, 
            ];
        }, $data['frequencies'] ?? []);

        $this->scheduleFrequencyRepository->upsert($frequency);
        return $res;
    }

    public function update($id, $data)
    {
        if(isset($data['expression']) && $data['expression'])
        {
            $data['frequencies'] = [];
            $this->scheduleFrequencyRepository->deleteByScheduleId($id);
        }
        else if(isset($data['frequencies']) && $data['frequencies'])
        {
            $data['expression'] = null;
        }

        $res = $this->mainRepository->update(
            $id,
            $data
        );

        if(isset($data['frequencies']) && $data['frequencies'])
        {
            $frequency = array_map(function($d) use ($res)
            {
                return [
                    'schedule_id'   => $res->id, 
                    'interval'      => $d['interval'],
                    'param_1'       => $d['param_1'] ?? null, 
                    'param_2'       => $d['param_2'] ?? null, 
                ];
            }, $data['frequencies'] ?? []);
            
            $this->scheduleFrequencyRepository->deleteByScheduleIdAndInterval($id, array_column($frequency, "interval"));
            $this->scheduleFrequencyRepository->upsert($frequency);
        }
        return $res;
    }

    public function delete($id)
    {
        $this->mainRepository->delete($id);
    }

    public function execute($id)
    {
        $schedule = $this->getById($id);
        $start = microtime(true);
        try {
            Artisan::call($schedule->command." ".$schedule->parameters);
            $output = Artisan::output();
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }

        $scheduleResult = $schedule->results()->create([
            'duration'  => 0,
            'result'    => "waiting finished execution",
        ]);
        
        dispatch(new ExecutedJob($scheduleResult, $start, $output));

        return null;
    }

    public function getCronExpression($schedule): string
    {
        $this->expression = $schedule->expression;
        if (!$this->expression) {
            $this->expression = '* * * * *';
            
            foreach ($schedule->frequencies as $frequency) {
                $param1 = $frequency->param_1;
                $param2 = $frequency->param_2;
                if($frequency->interval == "twiceDaily")
                {
                    $param1 = (int) $param1;
                    $param2 = (int) $param2;
                }
                call_user_func_array([$this, $frequency->interval], [$param1, $param2]);
            }
            $expression = $this->expression;
            $this->expression = null;
            return $expression;
        }
        return $this->expression;
    }

    public function when(Closure $callback): static
    {
        $this->filters[] = $callback;

        return $this;
    }

}