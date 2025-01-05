<?php

namespace App\Repository\Module;

use App\Helpers\Authorization;
use App\Models\Module\SatkerModel;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SatkerRepository extends BaseRepository
{
  protected $query;
  public function __construct()
  {
    $this->query = new SatkerModel();
  }

  public function withParent()
  {
    $this->query = $this->query->with(['parent:id,name']);
    return $this;
  }

  public function datatable()
  {
    $this->query = $this->query->query()
      ->from((new SatkerModel())->getTable() . " as g1")
      ->select(['g1.*', 'g2.name as parent_name'])
      ->leftJoin((new SatkerModel())->getTable() . " as g2", "g2.id", "g1.parent_id")
      ->groupBy(['g1.id']);
    return $this;
  }

  public function getByParentId($id): array
  {
    $tbl = (new SatkerModel())->getTable();
    return array_column(DB::select("
        select  id,
                name,
                parent_id
        from    (select * from $tbl order by parent_id, id) satkers_sorted,
                (select @pv := $id) initialisation
        where   find_in_set(parent_id, @pv)
        and     length(@pv := concat(@pv, ',', id))
        or      id = $id
    "), 'id');
  }

  public function filterByRole($tbl = "satkers")
  {
    if(!Authorization::hasPermission('satker.admin')) {
        if(Authorization::hasPermission('satker.auditee')) {
            $this->query = $this->query->where($tbl.'.id', Auth::user()->satker_id);
        }
        else if(Authorization::hasPermission('satker.upps')) {
            $satkerIds = (new SatkerRepository())->getByParentId(Auth::user()->satker_id);
            $this->query = $this->query->whereIn($tbl.'.id', $satkerIds);
        }
    }
    return $this;
  }

}
