<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExamAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_exam_answers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'user_exam_id', 'id_soal', 'nomor_soal', 'pilihan_acak', 'jawaban_user', 'poin'
    ];
    
    protected $casts = [
        'pilihan_acak' => 'array',
    ];
}
