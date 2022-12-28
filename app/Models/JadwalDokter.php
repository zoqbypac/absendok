<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'jadwalid';
    protected $fillable = [
        'kodedokter',
        'namadokter',
        'poliklinik',
        'hari',
        'waktu',
        'jam_mulai',
        'jam_selesai',
    ];
}
