<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('kondisi');
        });

        Schema::table('unit_ps', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('kondisi');
        });

        Schema::table('accessories', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('kondisi');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });

        Schema::table('unit_ps', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });

        Schema::table('accessories', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
};
