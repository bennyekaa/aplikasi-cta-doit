<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ref_jabatan';
    //---Set Primary Key---
    protected $primaryKey = 'id_jabatan';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul', 'id_modul');
    }
}
