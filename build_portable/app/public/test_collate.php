<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
use Illuminate\Support\Facades\DB;

$q1 = DB::select("SHOW FULL COLUMNS FROM user_exams");
$q2 = DB::select("SHOW FULL COLUMNS FROM ref_user");
$q3 = DB::select("SHOW FULL COLUMNS FROM ref_modul");

echo "user_exams:\n";
foreach($q1 as $col) {
    echo $col->Field . " - " . $col->Collation . "\n";
}
echo "\nref_user:\n";
foreach($q2 as $col) {
    echo $col->Field . " - " . $col->Collation . "\n";
}
echo "\nref_modul:\n";
foreach($q3 as $col) {
    echo $col->Field . " - " . $col->Collation . "\n";
}
