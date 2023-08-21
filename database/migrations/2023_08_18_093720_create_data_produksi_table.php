<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataProduksiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_produksi', function (Blueprint $table) {
            $table->id();
            $table->string('proses');
            $table->integer('target_quantity');
            $table->integer('quantity');
            $table->integer('finish_good');
            $table->integer('reject');
            $table->time('operating_time');
            $table->time('actual_time');
            $table->time('down_time')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_produksi');
    }
}
