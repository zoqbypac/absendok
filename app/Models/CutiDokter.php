<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiDokter extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'cuti_dokter';
    protected $primaryKey = 'cutiid';
    protected $fillable = [
        'kodedokter',
        'namadokter',
        'tglawal',
        'tglakhir',
        'keterangan',
    ];
}
