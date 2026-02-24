<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrowers', function (Blueprint $table) {

            $table->id('id_peminjam');

            $table->string('nama_peminjam', 30)->nullable();
            $table->enum('jk', ['L', 'P'])->default('L');
            $table->text('alamat')->nullable();
            $table->string('no_telpon', 15)->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->enum('status', ['siswa', 'guru', 'tendik', 'umum'])
                  ->default('siswa');

            $table->string('foto')->nullable();
            $table->string('nip', 20)->nullable();
            $table->string('nuptk', 20)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('kelas', 15)->nullable();
            $table->string('tahun_ajaran', 9)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};
