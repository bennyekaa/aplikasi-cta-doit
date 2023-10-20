<?php

namespace App\Models\Data;

use App\Models\Master\KategoriSoal;
use App\Models\Master\Pengguna;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'data_ujian';
    //---Set Primary Key---
    protected $primaryKey = 'id_ujian';

    public $incrementing = false;

    public $timestamps = false;
}
