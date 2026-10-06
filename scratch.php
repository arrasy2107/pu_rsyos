<?php
require __DIR__ . "/vendor/autoload.php";
$app = require_once __DIR__ . "/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    \Illuminate\Support\Facades\Auth::loginUsingId(130);
    $ruangan = 2;
    $pasienLama = \App\Models\Laporanumum::saldoPasienLama($ruangan);
    $ruangans = \App\Models\Ruangan::where("status", 1)->get();
    $html = view("pengawas.ajax.refresh-laporan-umum", compact("ruangan", "pasienLama", "ruangans"))->render();
    echo "SUCCESS: Length " . strlen($html);
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . " on line " . $e->getLine();
}

