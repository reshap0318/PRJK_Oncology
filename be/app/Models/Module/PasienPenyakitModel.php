<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienPenyakitModel extends Model
{
    use HasFactory;

    protected $table = 'sickness';

    protected $fillable = [
        "pasien_id",
        "description",
        "date_inspection",
        "is_family",
    ];

    protected $casts = [
        'date_inspection'   => 'date:d-m-Y',
        'is_family'         => 'boolean'
    ];

    public function pasien()
    {
        return $this->hasOne(PasienModel::class, 'id', 'pasien_id')->withDefault(['name' => 'tidak ditemukan']);
    }
}
