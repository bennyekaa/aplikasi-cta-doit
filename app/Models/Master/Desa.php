<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $table = 'ref_desa';
    protected $primaryKey = 'id_desa';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_desa', 'id_desa');
    }
}
