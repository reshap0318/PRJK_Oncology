<?php

namespace App\Http\Controllers;

use App\Helpers\Authorization;
use App\Http\Responses\Success;
use App\Models\UAM\PermissionModel;
use App\Models\UAM\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectController extends Controller
{
    public function index($type, Request $request)
    {
        $result = [];
        $payload = $request->all();
        if ($type == 'permission') {
            $result = $this->getPermission();
        } else if ($type == 'role') {
            $result = $this->getRole();
        } else if ($type == 'schedule') {
            $result = $this->getScheduleData();
        }
        return Success::defaultSuccessWithData($result);
    }

    private function getScheduleData(): array
    {
        return [
            'timezones'     => timezone_identifiers_list(),
            'frequencies'   => config('value.schedule.available_frequency'),
            'commands'      => config('value.schedule.available_command')
        ];
    }

    private function getPermission(): array
    {
        return PermissionModel::get(['id', 'name'])->toArray();
    }

    private function getRole(): array
    {
        return RoleModel::query()
            ->select(['id', 'name'])
            ->when(!Authorization::hasRole(1), function ($q) {
                return $q->whereNotIn('id', [1]);
            })
            ->get()->toArray();
    }
}
