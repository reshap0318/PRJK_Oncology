<?php

namespace App\Models\Module;

use DateTime;
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
        'dob'       => 'date:d-m-Y',
        'gender'    => 'boolean'
    ];

    protected function age(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $from = new DateTime($this->dob);
                $to   = new DateTime('today');
                echo $from->diff($to)->y;
            },
        );

    }

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
