<?php

use App\Http\Middleware\LogMiddleware;
use App\Jobs\Schedule\ExecutedJob;
use App\Services\System\ScheduleService;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'permission' => PermissionMiddleware::class,
            'role'       => RoleMiddleware::class,
            'log'        => LogMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        if (config('queue.default') == 'database') {
            $scheduleService = new ScheduleService();
            $list = $scheduleService->getData();
            $list->each(function ($data) use ($schedule, $scheduleService) {
                $event = $schedule->command($data->command . " " . $data->parameters);
                $event->cron($scheduleService->getCronExpression($data))
                    ->name($data->description)
                    ->timezone($data->timezone)
                    ->before(function () use ($data) {
                        // schedule before run function
                        $data->result = $data->results()->create([
                            'duration'  => 0,
                            'result'    => "waiting finished execution",
                        ]);
                        $data->start = microtime(true);
                    })
                    ->thenWithOutput(function ($output) use ($data) {
                        // schedule after run function
                        dispatch(new ExecutedJob($data->result, $data->start, $output));
                    });

                if ($data->dont_overlap) {
                    $event->withoutOverlapping();
                }

                if ($data->run_in_maintenance) {
                    $event->evenInMaintenanceMode();
                }

                if ($data->run_in_background) {
                    $event->runInBackground();
                }
            });
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
