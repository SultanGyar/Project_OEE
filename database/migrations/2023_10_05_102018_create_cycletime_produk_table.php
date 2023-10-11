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
        Schema::create('cycletime_produk', function (Blueprint $table) {
            $table->id();
            $table->string('daftarproses', 30);
            $table->foreign('daftarproses')->references('daftarproses')->on('proses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('size', 30);
            $table->string('class', 30);
            $table->integer('kapasitas_pcs');
            $table->string('kode', 30)->unique(); // Tipe data dan panjang karakter yang sama.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cycletime_produk');
    }
};
