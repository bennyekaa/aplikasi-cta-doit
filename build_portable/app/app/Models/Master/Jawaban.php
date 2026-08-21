<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'data_riwayat';
    //---Set Primary Key---
    protected $primaryKey = 'id_jawaban';

    public $incrementing = false;

    public function soal()
    {
        return $this->belongsTo(Soal::class, "id_soal", "id_soal");
    }
}
