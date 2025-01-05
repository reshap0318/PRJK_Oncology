<?php

namespace App\Repository\UAM;

use App\Models\UAM\PermissionModel;
use App\Repository\BaseRepository;

class PermissionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PermissionModel();
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

    public function getByRoleId(array $id = [])
    {
        $this->query = $this->query->whereHas('roles', function($q) use ($id)
        {
            return $q->whereIn('role_id', $id);
        });
        return $this;
    }
}