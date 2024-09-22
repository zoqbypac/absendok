<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KirimAbsen extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'absen_kirim';
    protected $fillable = [
        'absenid',
        'tanggal',
        'kirim',
        'status',
    ];
}
