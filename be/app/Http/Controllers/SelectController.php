<?php

namespace App\Http\Controllers;

use App\Helpers\Authorization;
use App\Http\Responses\Success;
use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanSitologiModel;
use App\Models\UAM\PermissionModel;
use App\Models\UAM\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        } else if ($type == 'dokter') {
            $result = $this->getDokter();
        } else if ($type == 'pasien') {
            $result = $this->getPasien();
        } else if ($type == 'sitologi-category') {
            $result = $this->getSitologiCategory();
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
            ->get()
            ->toArray();
    }

    private function getDokter(): array
    {
        return User::query()
            ->select(['id', 'name', 'is_active'])
            ->active()
            ->whereHas('roles', function($q) {
                return $q->where('role_id', User::R_DOKTER);
            })
            ->when(!Authorization::hasPermission('user.index') && Authorization::hasPermission('user.dokter'), function($q) {
                return $q->where('id', Auth::id());
            })
            ->get()
            ->toArray();
    }

    private function getPasien(): array
    {
        return PasienModel::query()
            ->select(['id', DB::raw("concat(no_mr, '-', name) as name")])
            ->get()
            ->toArray();
    }

    private function getSitologiCategory(): array
    {
        return array_map(function($d, $i) {
            return [
                'id' => $i,
                'name' => $d
            ];
        }, PemeriksaanSitologiModel::TYPE_LIST, array_keys(PemeriksaanSitologiModel::TYPE_LIST));
    }
}
