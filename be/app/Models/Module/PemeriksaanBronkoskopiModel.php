<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanBronkoskopiModel extends Model
{
    use HasFactory;
    protected $table = 'i_bronkoskopi';
    protected $primaryKey = 'id';

    protected $fillable = [
        "id",
        "vocal_cords",
        "trachea",
        "carina",

        "r_bu",
        "r_carina_second",
        "r_la",
        "r_lb",
        "r_ti",
        "r_lm",
        
        "l_bu",
        "l_carina_second",
        "l_la",
        "l_lb",
        "l_ld",
    ];
}
