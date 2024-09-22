<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseStation extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'nurse_station';
    protected $fillable = [
        'kodens',
        'namans',
    ];
}
