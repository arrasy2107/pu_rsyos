<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::select('SHOW TABLES');
foreach($tables as $t) {
    $table = array_values((array)$t)[0];
    $columns = DB::select("SHOW COLUMNS FROM `$table`");
    $hasAi = false;
    foreach($columns as $c) {
        if(strpos($c->Extra, 'auto_increment') !== false) {
            $hasAi = true;
            break;
        }
    }
    if(!$hasAi) {
        echo "$table is missing auto_increment\n";
    }
}
