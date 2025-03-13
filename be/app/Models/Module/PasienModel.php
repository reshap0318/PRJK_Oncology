<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PasienModel extends Model
{
    use HasFactory;

    protected $table = 'patient';

    protected $fillable = [
        "no_mr",
        "name",
        "gender",
        "dob",
        "pob",
        "phone",
        "email",
        "city",
        "province",
        "address",
        "education",
        "job",
        "ethnic"
    ];

    protected $casts = [
        'dob'       => 'date:Y-m-d',
        'gender'    => 'boolean'
    ];

    protected function gender(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? 'Laki-laki' : 'Perempuan',
        );
    }
    
    public function getTableCon(): string
    {
        return $this->getConnectionName() . "." . $this->getTable();
    }

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return [
                    'detail' => [
                        'isCan' => Authorization::hasPermission('pasien.show'),
                        'link'  => null,
                    ],
                    'edit' => [
                        'isCan' => Authorization::hasPermission('pasien.edit'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('pasien.delete'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }
}
