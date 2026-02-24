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
        Schema::create('borrowings', function (Blueprint $table) {

    $table->string('no_pinjam', 20)->primary();
    $table->dateTime('tgl_pinjam');

    $table->unsignedBigInteger('id_peminjam')->nullable();

    $table->integer('total_bayar')->default(0);
    $table->integer('total_denda')->default(0);

    $table->index('id_peminjam');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
