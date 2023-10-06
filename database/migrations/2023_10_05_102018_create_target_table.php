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
            $table->string('daftarproses', 30);
            $table->foreign('daftarproses')->references('daftarproses')->on('proses')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tanggal_target');
            $table->integer('target_quantity');
            $table->timestamps();
            $table->unique(['daftarproses', 'tanggal_target']);
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
