<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tablesToFix = [
    'catatan_pasien', 'dinas', 'dokter', 'dokter_irj', 'irj_buka',
    'jenis_pasien', 'laporan', 'laporan_ibs', 'laporan_ibs_detail',
    'laporan_igd', 'laporan_irj', 'laporan_irj_detail', 'laporan_umum',
    'log_jenis', 'piket', 'role', 'ruangan', 'sdmk_jenis', 'sdmk_subrumpun'
];

foreach($tablesToFix as $table) {
    echo "Fixing $table...\n";
    try {
        // First check if 'id' exists
        $columns = DB::select("SHOW COLUMNS FROM `$table`");
        $hasId = false;
        $isPri = false;
        $isAuto = false;
        foreach($columns as $c) {
            if($c->Field === 'id') {
                $hasId = true;
                if($c->Key === 'PRI') $isPri = true;
                if(strpos($c->Extra, 'auto_increment') !== false) $isAuto = true;
            }
        }
        
        if($hasId && !$isAuto) {
            if(!$isPri) {
                DB::statement("ALTER TABLE `$table` ADD PRIMARY KEY (`id`)");
            }
            DB::statement("ALTER TABLE `$table` MODIFY `id` INT NOT NULL AUTO_INCREMENT");
            echo "Fixed $table\n";
        } else {
            echo "Skipped $table (No id column, or already auto_increment)\n";
        }
    } catch(\Exception $e) {
        echo "Error fixing $table: " . $e->getMessage() . "\n";
    }
}
