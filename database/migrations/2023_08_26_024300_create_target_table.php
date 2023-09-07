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
        Schema::create('target', function (Blueprint $table) {
            $table->id();
            $table->string('target_proses', 30);
            $table->foreign('target_proses')->references('daftarproses')->on('proses')->onDelete('cascade');
            $table->date('tanggal_target');
            $table->integer('target_quantity_byadmin');
            $table->timestamps();
            $table->unique(['target_proses', 'tanggal_target']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target');
    }
};
