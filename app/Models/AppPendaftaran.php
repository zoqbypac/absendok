<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPendaftaran extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'app_pendaftaran';
    protected $primaryKey = 'appid';
    protected $fillable = [
        'jamApp',
        'tglApp',
        'mrn',
        'namapasien',
        'notelp',
        'namadokter',
        'poliklinik',
        'status',
    ];
}
