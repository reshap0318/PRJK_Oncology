<?php

namespace App\Repository\UAM;

use App\Models\UAM\RoleModel;
use App\Repository\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new RoleModel();
    }

    public function withPermissions()
    {
        $this->query = $this->query->with(['permissions:id,name,keterangan']);
        return $this;
    }

    public function getByAppId($id)
    {
        $this->keyCache = "getByAppId-".$id;
        $this->query = $this->query->where('application_id', $id);
        return $this;
    }

    public function getById($id)
    {
        $this->query = $this->query->where('id', $id);
        return $this;
    }
}