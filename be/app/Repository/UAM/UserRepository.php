<?php

namespace App\Repository\UAM;

use App\Helpers\Authorization;
use App\Models\Module\SatkerModel;
use App\Models\UAM\RoleModel;
use App\Models\User;
use App\Repository\BaseRepository;
use App\Repository\Module\SatkerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new User();
    }

    public function datatable()
    {
        $this->query = $this->query->query()
            ->select([
                'users.*',
                's.name as satker_name',
                DB::raw("group_concat(r.name) as role_names"),
                DB::raw("group_concat(r.id) as role_ids")
            ])
            ->leftJoin((new SatkerModel())->getTable() . " as s", "s.id", "users.satker_id")
            ->leftJoin("user_has_roles as uhr", "uhr.user_id", "users.id")
            ->leftJoin((new RoleModel())->getTable() . " as r", "r.id", "uhr.role_id")
            ->groupBy(['users.id']);
        return $this;
    }

    public function withRole()
    {
        $this->query = $this->query->with(['roles:id,name']);
        return $this;
    }

    public function filterByRole($tbl = 'users')
    {
        if(!Authorization::hasPermission('satker.admin')) {
            if(Authorization::hasPermission('satker.auditee')) {
                $this->query = $this->query->where($tbl.'.satker_id', Auth::user()->satker_id);
            }
            else if(Authorization::hasPermission('satker.upps')) {
                $satkerIds = (new SatkerRepository())->getByParentId(Auth::user()->satker_id);
                $this->query = $this->query->whereIn($tbl.'.satker_id', $satkerIds);
            }
        }
        return $this;
    }

    public function filterById($id)
    {
        $this->query = $this->query->where('id', $id);
        return $this;
    }

    public function filterByUsername($username)
    {
        $this->query = $this->query->where('username', $username);
        return $this;
    }

    public function filterByName($input)
    {
        $this->query = $this->query->where('name', 'like', "%$input%");
        return $this;
    }

    public function filterBySatkerIds($ids)
    {
        $this->query = $this->query->whereIn('satker_id', $ids);
        return $this;
    }
}
