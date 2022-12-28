<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'absensi';
    protected $primaryKey = 'absenid';
    protected $fillable = [
        'jadwalid',
        'tanggal',
        'kodedokter',
        'namadokter',
        'poliklinik',
        'hari',
        'waktu',
        'jam_mulai',
        'jam_selesai',
        'jam_masuk',
        'jam_pulang',
        'selisih_masuk',
        'selisih_pulang',
        'keterangan',
    ];
}
