<?php

namespace App\Services\UAM;

use App\Models\Module\AnggotaRequestModel;
use App\Models\Module\SatkerModel;
use App\Repository\UAM\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new UserRepository();
    }

    public function getById($id)
    {
        // return $this->transaction(function() use ($id) {
        //     $data = $this->mainRepository->withRoles()->withDepartment()->getById($id)->first();
        //     abort_if(!$data, 404, "halaman tidak ditemukan");

        //     $data->last_login_txt = $data->last_login ? $data->last_login->diffForHumans() : null;
        //     return $data;
        // })->commandResult();
    }

    public function getListData()
    {
        // return $this->transaction(function() {
        //     return $this->mainRepository
        //         ->filterWithoutProgrammer()
        //         ->withRoles()
        //         ->when(request()->has('app_id'), function($q) {
        //             $appId = request()->get('app_id');
        //             return $q->whereHas('roles', function($q) use ($appId) {
        //                 return $q->where('application_id', $appId);
        //             });
        //         })
        //         ->paginate(['total' => 8]);
        // })->commandResult();
    }

    public function datatable($payload)
    {
        $satker = $payload['satker_id'] ?? null;
        
        $query = $this->mainRepository->datatable()
            ->when($satker, function ($q) use ($satker) {
                return $q->where(function($q) use ($satker) {
                    return $q->where('users.satker_id', $satker)->orWhereIn('users.satker_id', SatkerModel::select('id')->where('parent_id', $satker));
                });
            })
            ->filterByRole()
            ->getQuery();
        return DataTables::eloquent($query)
            ->addColumn('avatar_url', function ($data) {
                return $data->avatar_url;
            })
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function create($data)
    {
        $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        $res = $this->mainRepository->create($data);
        $res->roles()->sync($data['roles']);
        if (isset($data['avatar']) && $data['avatar']->isValid()) {
            $fileName = $res->username . "." . $data['avatar']->extension();
            $path = $data['avatar']->storeAs('avatar', $fileName);
            $res->update(['avatar_path' => $path]);
        }
        return $res;
    }

    public function update($id, $data)
    {
        if (array_key_exists("password", $data) && $data['password'] == null) {
            unset($data['password']);
        }

        $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
        $res = $this->mainRepository->update($id, $data);
        $res->roles()->sync($data['roles']);

        if (isset($data['avatar']) && $data['avatar']->isValid()) {
            $fileName = $res->username . "." . $data['avatar']->extension();
            $path = $data['avatar']->storeAs('avatar', $fileName);
            $res->update(['avatar_path' => $path]);
        }
        return $res;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        if ($data->avatar_path) Storage::delete($data->avatar_path);
        return $this->mainRepository->delete($id);
    }
}
