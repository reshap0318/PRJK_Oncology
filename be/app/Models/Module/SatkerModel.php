<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SatkerModel extends Model
{
    use HasFactory;

    protected $table = "satkers";
    protected $primaryKey = 'id';

    protected $fillable = [
        'parent_id',
        'name',
    ];

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return [
                    'edit' => [
                        'isCan' => Authorization::hasPermission('satker.edit'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('satker.delete'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    public function parent()
    {
        return $this->hasOne(SatkerModel::class, 'id', 'parent_id');
    }

    public function childs()
    {
        return $this->hasOne(SatkerModel::class, 'parent_id', 'id');
    }
}
