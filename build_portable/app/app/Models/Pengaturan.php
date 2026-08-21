<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pengaturan';
    //---Set Primary Key---
    protected $primaryKey = 'id_pengaturan';

    public $incrementing = false;

    protected $fillable = [
        'instansi',
        'logo',
        'font_type',
        'font_size',
    ];
}
