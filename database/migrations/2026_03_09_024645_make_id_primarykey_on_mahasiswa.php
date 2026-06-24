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
        if (\Illuminate\Support\Facades\DB::connection($this->getConnection())->getDriverName() === 'sqlite') {
            Schema::dropIfExists('mahasiswas');
            Schema::create('mahasiswas', function (Blueprint $table) {
                $table->id();
                $table->string('nim');
                $table->string('nama');
                $table->foreignId('program_studi_id')->constrained('program_studis');
                $table->year('tahun_masuk')->nullable();
                $table->timestamps();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users');
            });
        } else {
            Schema::table('mahasiswas', function (Blueprint $table) {
                $table->dropPrimary(['nim']);
                $table->id()->first();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
