<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapPoli extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'map_poli';
    protected $primaryKey = 'mapid';
    protected $fillable = [
        'poliklinik',
        'kategori',
    ];
}
