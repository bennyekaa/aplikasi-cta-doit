<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ref_soal';
    //---Set Primary Key---
    protected $primaryKey = 'id_soal';

    public $incrementing = false;

    public function kategori()
    {
        return $this->belongsTo(KategoriSoal::class, "id_kategori_soal", "id_kategori_soal");
    }

}
