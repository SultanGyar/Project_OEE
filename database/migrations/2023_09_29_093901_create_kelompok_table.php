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
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok', 30);
            $table->string('proses_kelompok', 30);
            $table->foreign('proses_kelompok')->references('daftarproses')->on('proses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->unique(['nama_kelompok', 'proses_kelompok']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok');
    }
};
