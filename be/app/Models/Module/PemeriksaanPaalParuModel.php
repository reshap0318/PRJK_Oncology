<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanPaalParuModel extends Model
{
    use HasFactory;
    protected $table = 'i_paal_lungs';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "kvp_ml",
        "kvp_percent",
        "vep_ml",
        "vep_percent",
        "vep_kvp",
        "description"
    ];

    protected $casts = [
        "kvp_ml"        => "float:5,2",
        "kvp_percent"   => "float:3,2",
        "vep_ml"        => "float:5,2",
        "vep_percent"   => "float:3,2",
        "vep_kvp"       => "float:3,2",
    ];

    public function inspection()
    {
        return $this->belongsTo(PasienPemeriksaanModel::class, 'id', 'id');
    }
}
