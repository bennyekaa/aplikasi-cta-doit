<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSoal extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ref_kategori';
    //---Set Primary Key---
    protected $primaryKey = 'id_kategori';

    public $incrementing = false;
    protected $guarded = [];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }
}
