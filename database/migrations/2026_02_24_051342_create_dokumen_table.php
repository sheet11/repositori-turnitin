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
    Schema::create('dokumens', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->enum('jenis_dokumen',['Skripsi','Jurnal','Proposal','KTI']);
        $table->string('nim');
        $table->string('file_asli');
        $table->string('bukti_bayar')->nullable();
        $table->timestamp('tanggal_upload');
        $table->enum('status',['Pending','Di Proses','Ditolak','Selesai'])->default('Pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
