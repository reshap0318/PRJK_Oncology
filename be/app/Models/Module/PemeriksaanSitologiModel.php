<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanSitologiModel extends Model
{
    use HasFactory;
    protected $table = 'i_sitologi';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "category",
        "date",
        "type",
        "type_detail",
        "description"
    ];

    protected $casts = [
        "date"          => 'date:Y-m-d',
        "category"      => 'integer',
        "type"          => 'integer',
        "type_detail"   => 'integer',
    ];

    const K_SPUTUM = 1;
    const K_CAIRAN_PLEURA = 2;
    const K_BIOPSI_PLEURA = 3;
    const K_BILASAN_BRONKUS = 4;
    const K_SIKATAN_BRONKUS = 5;
    const K_BIOPSI_VORCEP = 6;
    const K_CRYOBIOPSI = 7;
    const K_TTNA = 8;
    const K_TTB = 9;
    const K_BJH = 10;
    const K_LAINNYA = 11;

    const T_SMALL = 1;
    const T_SQUAM = 2;
    const T_ADENO = 3;
    const T_LARGE = 4;

    const CATEGORY_LIST = [
        self::K_SPUTUM => "Sputum",
        self::K_CAIRAN_PLEURA => "Cairan Pleura",
        self::K_BIOPSI_PLEURA => "Biopsi Pleura",
        self::K_BILASAN_BRONKUS => "Bilasan Bronkus",
        self::K_SIKATAN_BRONKUS => "Sikatan Bronkus",
        self::K_BIOPSI_VORCEP => "Biopsi Vorcep",
        self::K_CRYOBIOPSI => "Cryobiopsi",
        self::K_TTNA => "TTNA",
        self::K_TTB => "TTB",
        self::K_BJH => "BJH",
        self::K_LAINNYA => "Lainnya",
    ];

    const TYPE_LIST = [
        self::T_SMALL => "Small Cell Ca",
        self::T_SQUAM => "Squam (Non Small Cell Ca)",
        self::T_ADENO => "Adeno (Non Small Cell Ca)",
        self::T_LARGE => "Large (Non Small Cell Ca)",
    ];

    protected function categoryText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return self::CATEGORY_LIST[$this->category] ?? '-';
            }
        );
    }

    protected function typeText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return self::TYPE_LIST[$this->type_detail] ?? '-';
            }
        );
    }
}
