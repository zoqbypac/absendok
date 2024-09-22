<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlasanTelat extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'alasan_telat';
    protected $fillable = [
        'jenis_telat',
        'eksklusi',
    ];
}
