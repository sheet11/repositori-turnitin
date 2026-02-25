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
    Schema::create('hasil_turnitin', function (Blueprint $table) {
        $table->id();
        $table->foreignId('dokumen_id')->constrained('dokumen');
        $table->decimal('similarity_index',5,2);
        $table->string('file_laporan');
        $table->timestamp('tanggal_cek');
        $table->foreignId('operator_id')->constrained('users');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_turnitin');
    }
};
