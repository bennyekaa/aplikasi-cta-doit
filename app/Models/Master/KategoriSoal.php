<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSoal extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ref_kategori_soal';
    //---Set Primary Key---
    protected $primaryKey = 'id_kategori_soal';

    public $incrementing = false;

    protected $fillable = [
        'id_kategori_soal',
        'nama_kategori_soal',
        'aktif',
        'created_at',
        'created_by'
    ];
}
