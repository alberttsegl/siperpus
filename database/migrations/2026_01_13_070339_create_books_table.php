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
    Schema::create('books', function (Blueprint $table) {

        // PRIMARY KEY MANUAL (bukan id())
        $table->string('kdbuku', 10)->primary();

        $table->string('judul', 255)->nullable();
        $table->string('jenis', 50)->nullable();
        $table->char('tahun_terbit', 4)->nullable();
        $table->string('penulis', 30)->nullable();
        $table->string('penerbit', 50)->nullable();
        $table->integer('stock')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
