<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_details', function (Blueprint $table) {

            $table->id();

            $table->string('no_nota', 20)->nullable();
            $table->string('kdbuku', 10)->nullable();

            $table->integer('jumlah_beli')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->integer('subtotal')->default(0);

            // FK ke purchases
            $table->foreign('no_nota')
                  ->references('no_nota')
                  ->on('purchases')
                  ->cascadeOnDelete();

            // FK ke books
            $table->foreign('kdbuku')
                  ->references('kdbuku')
                  ->on('books')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
