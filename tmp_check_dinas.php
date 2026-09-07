<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
foreach (App\Models\Dinas::all() as $d) {
    echo sprintf("%s|%s|%s|%s\n", $d->id, $d->jam_masuk ?? 'NULL', $d->jam_pulang ?? 'NULL', $d->dinas ?? 'NULL');
}
