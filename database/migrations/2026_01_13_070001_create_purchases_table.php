<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {

            $table->string('no_nota', 20)->primary();
            $table->dateTime('tgl_nota')->nullable();

            $table->unsignedBigInteger('id_distributor')->nullable();
            $table->integer('total_bayar')->default(0);

            $table->foreign('id_distributor')
                  ->references('id_distributor')
                  ->on('distributors')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
