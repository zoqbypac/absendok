<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPeralihan extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'jadwal_peralihan';
    protected $primaryKey = 'jadwalid';
    protected $fillable = [
        'tanggal',
        'kodedokter',
        'namadokter',
        'poliklinik',
        'hari',
        'waktu',
        'jam_mulai',
        'jam_selesai',
    ];
}
