<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user');
            $table->foreign('nama_user')->references('full_name')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->string('daftarproses', 30);
            $table->date('tanggal')->default(DB::raw('CURRENT_DATE'));
            $table->integer('kapasitas_pcs');
            $table->integer('target_quantity');
            $table->string('daftarkelompok', 50);
            $table->string('kode', 30);
            $table->foreign('kode')->references('kode')->on('cycletime_produk')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('quantity');
            $table->integer('finish_good');
            $table->integer('reject')->nullable();
            $table->string('daftarketerangan', 50)->nullable();
            $table->foreign('daftarketerangan')->references('daftarketerangan')->on('keterangan')->onDelete('restrict')->onUpdate('cascade');
            $table->time('operating_start_time')->nullable();
            $table->time('operating_end_time')->nullable();
            $table->time('operating_time');
            $table->time('down_time')->nullable();
            $table->time('actual_time');
            $table->time('a_start_time')->nullable();
            $table->time('a_end_time')->nullable();
            $table->time('a_time')->nullable();
            $table->time('b_start_time')->nullable();
            $table->time('b_end_time')->nullable();
            $table->time('b_time')->nullable();
            $table->time('c_start_time')->nullable();
            $table->time('c_end_time')->nullable();
            $table->time('c_time')->nullable();
            $table->time('d_start_time')->nullable();
            $table->time('d_end_time')->nullable();
            $table->time('d_time')->nullable();
            $table->time('e_start_time')->nullable();
            $table->time('e_end_time')->nullable();
            $table->time('e_time')->nullable();
            $table->time('f_start_time')->nullable();
            $table->time('f_end_time')->nullable();
            $table->time('f_time')->nullable();
            $table->time('g_start_time')->nullable();
            $table->time('g_end_time')->nullable();
            $table->time('g_time')->nullable();
            $table->time('h_start_time')->nullable();
            $table->time('h_end_time')->nullable();
            $table->time('h_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
