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
        Schema::create('anggota_kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('daftarkelompok', 30);
            $table->foreign('daftarkelompok')->references('daftarkelompok')->on('kelompok')->onDelete('cascade')->onUpdate('cascade');
            $table->string('daftarproses', 30);
            $table->foreign('daftarproses')->references('daftarproses')->on('proses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->unique(['daftarkelompok', 'daftarproses']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_kelompok');
    }
};
