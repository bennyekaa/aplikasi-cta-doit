<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasFactory;
    protected $table = 'bank_soal';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_modul',
        'id_tematik',
        'soal',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'kunci',
        'created_by',
        'updated_by'
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }

    public function tematik()
    {
        return $this->belongsTo(KategoriSoal::class, 'id_tematik', 'id_kategori');
    }
}
