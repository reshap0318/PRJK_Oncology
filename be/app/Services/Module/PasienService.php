<?php

namespace App\Services\Module;

use App\Repository\Module\PasienRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class PasienService extends BaseService
{
    protected $mainRepository;
    public function __construct() {
        $this->mainRepository = new PasienRepository();
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
        $data['gender'] = filter_var($data['gender'], FILTER_VALIDATE_BOOLEAN);
        $res = $this->mainRepository->create($data);
        return $res;
    }

    public function update($id, $data)
    {
        $data['gender'] = filter_var($data['gender'], FILTER_VALIDATE_BOOLEAN);
        $res = $this->mainRepository->update($id, $data);
        return $res;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}