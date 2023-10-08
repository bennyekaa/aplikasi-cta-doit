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


    public $timestamps = false;


    public function kategori()
    {
        return $this->belongsTo(KategoriSoal::class, "id_kategori_soal", "id_kategori_soal");
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, "id_modul", "id_modul");
    }

    protected $fillable = [
        'id_soal',
        'id_kategori_soal',
        'soal',
        'pembahasan',
        // 'file',
        'jawaban_a',
        'poin_a',
        'jawaban_b',
        'poin_b',
        'jawaban_c',
        'poin_c',
        'jawaban_d',
        'poin_d',
        'jawaban_e',
        'poin_e',
        'created_at',
        'created_by'
    ];
}
