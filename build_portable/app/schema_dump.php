<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['ref_kategori', 'ref_modul', 'ref_user', 'bank_soal', 'user_exams'];
foreach($tables as $table) {
    echo "--- $table ---\n";
    print_r(Illuminate\Support\Facades\Schema::getColumnListing($table));
}
