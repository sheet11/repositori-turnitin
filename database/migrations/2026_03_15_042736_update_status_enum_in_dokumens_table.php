<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL: Add 'Sudah Dicek' to the status ENUM list.
        DB::statement("ALTER TABLE dokumens MODIFY COLUMN status ENUM('Pending', 'Diproses', 'Sudah Dicek', 'Ditolak', 'Selesai') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back without 'Sudah Dicek' (Make sure there's no data relying on 'Sudah Dicek' otherwise this will fail)
        DB::statement("ALTER TABLE dokumens MODIFY COLUMN status ENUM('Pending', 'Diproses', 'Ditolak', 'Selesai') DEFAULT 'Pending'");
    }
};
