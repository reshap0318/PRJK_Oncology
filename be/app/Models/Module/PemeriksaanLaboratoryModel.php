<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanLaboratoryModel extends Model
{
    use HasFactory;
    protected $table = 'i_laboratory_result';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "date",
        "result_path",
        "hb",
        "leukosit",
        "ht",
        "tr",
        "dc",
        "liver_function",
        "procalsitonin",
        "ginjal_ur",
        "ginjal_cr",
        "ginjal_cct",
        "elektrolit_na",
        "elektrolit_k",
        "elektrolit_cl",
        "agd_ph",
        "agd_pco2",
        "agd_po2",
        "agd_hco3",
        "agd_be",
        "agd_so2",
        "gds",
        "description"
    ];

    protected $casts = [
        'date'              => 'date:d-m-Y',
        "hb"                => "float:3,2",
        "leukosit"          => "float:3,2",
        "ht"                => "float:3,2",
        "tr"                => "float:3,2",
        "ginjal_ur"         => "float:3,2",
        "ginjal_cr"         => "float:3,2",
        "ginjal_cct"        => "float:3,2",
        "elektrolit_na"     => "float:3,2",
        "elektrolit_k"      => "float:3,2",
        "elektrolit_cl"     => "float:3,2",
        "agd_ph"            => "float:3,2",
        "agd_pco2"          => "float:3,2",
        "agd_po2"           => "float:3,2",
        "agd_hco3"          => "float:3,2",
        "agd_be"            => "float:3,2",
        "agd_so2"           => "float:3,2",
        "gds"               => "float:3,2",
    ];

    protected $appends = [
        'result_url',
    ];

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return [
                    'edit' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.inspection'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.inspection'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    protected function resultUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->result_path ? route('file.index', ['name' => str_replace("/", "_", $this->result_path)]) : null;
            }
        );
    }
}
