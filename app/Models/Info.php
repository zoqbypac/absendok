<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'info';
    protected $primaryKey = 'infoid';
    protected $fillable = [
        'userid',
        'waktu',
        'pesan',
    ];
}
