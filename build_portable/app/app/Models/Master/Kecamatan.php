<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'ref_kecamatan';
    protected $primaryKey = 'id_kecamatan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function desa()
    {
        return $this->hasMany(Desa::class, 'id_kecamatan', 'id_kecamatan');
    }
}
