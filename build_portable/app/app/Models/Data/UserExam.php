<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    use HasFactory;

    protected $table = 'user_exams';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'id_user', 'id_modul', 'waktu_mulai', 'waktu_selesai', 'status', 'nilai'
    ];
}
