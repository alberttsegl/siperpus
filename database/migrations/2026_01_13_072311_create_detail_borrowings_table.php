<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_borrowings', function (Blueprint $table) {

            $table->string('no_pinjam', 20)->nullable();
            $table->string('kdbuku', 10)->nullable();
            $table->date('tgl_kembali')->nullable();

            $table->integer('denda_perhari')->default(0);
            $table->integer('jumlah_terlambat')->default(0);
            $table->integer('bayar_denda')->default(0);
            $table->integer('jumlah_pinjam')->default(0);

            $table->enum('status_pinjam', ['P', 'K'])->default('P');
            $table->text('keterangan')->nullable();

            $table->index('no_pinjam');
            $table->index('kdbuku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_borrowings');
    }
};
