<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanOutcomeModel extends Model
{
    use HasFactory;

    protected $table = 'i_outcome';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "progress",
        "dead",
        "description",
    ];

    protected $casts = [
        "progress"      => 'date:Y-m-d',
        'dead'          => 'date:Y-m-d'
    ];
}
