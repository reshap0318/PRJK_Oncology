<?php

namespace App\Services\UAM;

use App\Repository\UAM\PermissionRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class PermissionService extends BaseService
{
    protected $mainRepository;
    public function __construct() {
        $this->mainRepository = new PermissionRepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->getById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        return $data;
    }

    public function datatable()
    {
        $query = $this->mainRepository->getQuery()->query();
        
        return DataTables::eloquent($query)
            ->addColumn('action', function($data)
            {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function create($data)
    {
        $res = $this->mainRepository->create($data);
        return $res;
    }

    public function update($id, $data)
    {
        $res = $this->mainRepository->update($id, $data);
        return $res;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}