<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\User::all() as $u) {
    echo implode('|', [$u->id, $u->nama, $u->username, $u->id_role, $u->status]) . PHP_EOL;
}
