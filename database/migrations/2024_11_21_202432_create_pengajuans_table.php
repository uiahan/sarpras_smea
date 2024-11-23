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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('barang');
            $table->string('program_kegiatan');
            $table->string('jurusan');
            $table->date('tanggal_ajuan');
            $table->date('tanggal_realisasi')->nullable();
            $table->integer('harga_satuan');
            $table->string('tahun');
            $table->integer('banyak');
            $table->integer('total_harga');
            $table->string('catatan')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('keterangan');
            $table->enum('status', ['Diajukan', 'Diterima', 'Diperbaiki', 'Dibelikan', 'Di Sarpras', 'Dijurusan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
