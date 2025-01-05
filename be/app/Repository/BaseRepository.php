<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use function PHPUnit\Framework\callback;

class BaseRepository
{
    protected $query;
    protected $keyCache = null;
    private $cacheOn = false;

    public function __construct()
    {
        $this->cacheOn = config('app.cache_on');
        if (request()->has('cache-reset') && request()->query('cache-reset') == 1) {
            $this->cacheOn = false;
        }
    }

    public function get()
    {
        return $this->resolveResource(function () {
            return $this->query->get();
        });
    }

    public function count()
    {
        return $this->resolveResource(function () {
            return $this->query->count();
        });
    }

    public function first()
    {
        return $this->resolveResource(function () {
            return $this->query->first();
        });
    }

    public function paginate($request = [])
    {
        $data = array_merge([
            'total' => 10,
            'field' => ['*'],
            'pageName' => 'page'
        ], $request);
        return $this->query->paginate($data['total'], $data['field'], $data['pageName']);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function when($on, $on_function, $not_on_function = null)
    {
        if ($on) {
            $this->query = $on_function($this->query);
        } else if ($not_on_function != null) {
            $this->query = $not_on_function($this->query);
        }
        return $this;
    }

    private function resolveResource($some_function)
    {
        if ($this->cacheOn && $this->keyCache) {
            $key = (Auth::id() ?? "system") . "-" . $this->keyCache;
            if (Cache::has($key)) {
                return Cache::get($key);
            }

            $data = $some_function();
            Cache::put($key, $data, 600); //600 minute
            return $data;
        }
        return $some_function();
    }

    public function filterById($id)
    {
        $this->query = $this->query->where('id', $id);
        return $this;
    }

    public function filterByCode($code)
    {
        $this->query = $this->query->where('code', $code);
        return $this;
    }

    public function create($data)
    {
        $res = $this->query->create($data);
        return $res;
    }

    public function insert($data)
    {
        $res = $this->query->insert($data);
        return $res;
    }

    public function update($id, $data)
    {
        if (!$id instanceof $this->query) {
            $id = $this->query->find($id);
            abort_if(!$id, 404, "halaman tidak ditemukan");
        }
        $id->update($data);
        return $id;
    }

    public function delete($id)
    {
        if (!$id instanceof $this->query) {
            $id = $this->query->find($id);
            abort_if(!$id, 404, "halaman tidak ditemukan");
        }
        $id->delete();
        return $id;
    }

    public function deleteSelected($ids)
    {
        if (!$ids instanceof $this->query) {
            $id = $this->query->whereIn('id', $ids);
        }
        $id->delete();
        return $id;
    }

    public function upsert(array $data, array $unique = [], array $update = [])
    {
        $update = $update ?? array_keys($data[0]);
        $res = $this->query->upsert($data,  uniqueBy: $unique, update: $update);
        return $res;
    }
}
