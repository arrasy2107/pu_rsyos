<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah kolom qr_token dan qr_code ke tabel laporan.
     * Kedua kolom nullable agar data laporan lama tidak terpengaruh sama sekali.
     */
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            // qr_token: HMAC-SHA256 hash unik per laporan untuk verifikasi keaslian
            $table->string('qr_token', 64)->nullable()->after('signature');
            // qr_code: nama file PNG QR Code yang disimpan di storage/app/public/qrcodes/
            $table->string('qr_code', 255)->nullable()->after('qr_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['qr_token', 'qr_code']);
        });
    }
};
