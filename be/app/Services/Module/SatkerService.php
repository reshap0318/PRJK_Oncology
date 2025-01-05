<?php

namespace App\Services\Module;

use App\Repository\Module\SatkerPimpinanRepository;
use App\Repository\Module\SatkerRepository;
use App\Repository\UAM\UserRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class SatkerService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new SatkerRepository();
    }

    public function datatable()
    {
        $query = $this->mainRepository->datatable()->filterByRole("g1")->getQuery();
        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function getData($id)
    {
        $data = $this->mainRepository->withParent()->filterByRole()->filterById($id)->first();
        abort_if(!$data, 404, __('messages.404'));

        $childrens = $this->mainRepository->getByParentId($id);
        $data->user_total = (new UserRepository())->filterBySatkerIds($childrens)->count();
        $data->pimpinan_total = (new SatkerPimpinanRepository())->filterBySatkerId($id)->count();
        return $data;
    }

    public function create($payload)
    {
        $data = $this->mainRepository->create($payload);

        $update = [];
        if (isset($payload['ami']) && $payload['ami']->isValid()) {
            $fileName = $data->id . "-2022-ami." . $payload['ami']->extension();
            $path = $payload['ami']->storeAs('satkerAMI', $fileName);
            $update = array_merge($update, ['ami_path' => $path]);
        }

        if (isset($payload['rtm']) && $payload['rtm']->isValid()) {
            $fileName = $data->id . "-2022-rtm." . $payload['rtm']->extension();
            $path = $payload['rtm']->storeAs('satkerRTM', $fileName);
            $update = array_merge($update, ['rtm_path' => $path]);
        }

        $data->update($update);
        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterByRole()->filterById($id)->first();
        abort_if(!$data, 404, __('messages.404'));

        if (isset($payload['ami']) && $payload['ami']->isValid()) {
            $fileName = $data->id . "-2022-ami." . $payload['ami']->extension();
            $path = $payload['ami']->storeAs('satkerAMI', $fileName);
            $payload = array_merge($payload, ['ami_path' => $path]);
        }

        if (isset($payload['rtm']) && $payload['rtm']->isValid()) {
            $fileName = $data->id . "-2022-rtm." . $payload['rtm']->extension();
            $path = $payload['rtm']->storeAs('satkerRTM', $fileName);
            $payload = array_merge($payload, ['rtm_path' => $path]);
        }

        $data->update($payload);
        return $data;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}
