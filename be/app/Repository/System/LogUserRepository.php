<?php

namespace App\Repository\System;

use App\Models\System\LogUserModel;
use App\Repository\BaseRepository;

class LogUserRepository extends BaseRepository
{
    protected $query;
    public function __construct() {
        $this->query = new LogUserModel();
    }

    public function filterById($id)
    {
        $this->query = $this->query->where('id', $id);
        return $this;
    }

    public function filterByUserId($id)
    {
        $this->query = $this->query->where('user_id', $id);
        return $this;
    }

    public function withUser()
    {
        $this->query = $this->query->with(['user:id,name']);
        return $this;
    }

    public function orderDesc()
    {
        $this->query = $this->query->orderBy('server_time', 'desc');
        return $this;
    }
}