<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
use Illuminate\Support\Facades\DB;

// Ubah poin yang sebelumnya 5 menjadi 1
DB::table('user_exam_answers')->where('poin', 5)->update(['poin' => 1]);

// Hitung ulang total nilai untuk semua user_exams
$exams = DB::table('user_exams')->get();
foreach ($exams as $exam) {
    $total_poin = DB::table('user_exam_answers')->where('user_exam_id', $exam->id)->sum('poin');
    DB::table('user_exams')->where('id', $exam->id)->update(['nilai' => $total_poin]);
    echo "Updated exam ID {$exam->id} with new score: {$total_poin}\n";
}
echo "Selesai.";
