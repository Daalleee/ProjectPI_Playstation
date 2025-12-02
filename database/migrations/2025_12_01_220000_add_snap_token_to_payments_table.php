<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Snap token untuk melanjutkan pembayaran yang tertunda
            $table->text('snap_token')->nullable()->after('order_id');
            // Menyimpan data payment instructions (VA number, QRIS URL, dll)
            $table->text('payment_instructions')->nullable()->after('snap_token');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'payment_instructions']);
        });
    }
};
