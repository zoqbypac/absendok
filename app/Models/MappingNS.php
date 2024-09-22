<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MappingNS
 *
 * @property int $id
 * @property string $poliklinik
 * @property string $ns
 * @property string $kasir
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS query()
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS whereKasir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS whereNs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS wherePoliklinik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MappingNS whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MappingNS extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'mapping_n_s';
    protected $fillable = [
        'poliklinik',
        'ns',
        'kasir'
    ];
}
