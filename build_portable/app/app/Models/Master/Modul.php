<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'ref_modul';
    //---Set Primary Key---
    protected $primaryKey = 'id_modul';

    public $incrementing = false;

    protected $guarded = [];
}