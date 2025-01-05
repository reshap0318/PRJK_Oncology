<?php

namespace App\Services\UAM;

use App\Repository\UAM\PermissionRepository;
use App\Repository\UAM\RoleRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class RoleService extends BaseService
{
    protected $mainRepository;
    public function __construct() {
        $this->mainRepository = new RoleRepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->getById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        return $data;
    }

    public function datatable()
    {
        $query = $this->mainRepository->withPermissions()->getQuery();
        
        return DataTables::eloquent($query)
            ->addColumn('action', function($data)
            {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function create($data)
    {
        $res = $this->mainRepository->create([
            'name'  => $data['name'],
        ]);
        $res->permissions()->sync($data['permissions']);
        return $res;
    }

    public function update($id, $data)
    {
        $res = $this->mainRepository->update($id, ['name'  => $data['name']]);
        $res->permissions()->sync($data['permissions']);
        return $res;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}