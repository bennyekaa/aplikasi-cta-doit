<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$soals = \App\Models\Master\BankSoal::limit(3)->get();
echo json_encode($soals, JSON_PRETTY_PRINT);
