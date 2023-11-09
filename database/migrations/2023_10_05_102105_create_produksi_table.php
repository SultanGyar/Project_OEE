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
            $table->string('produk_size', 30);
            $table->string('produk_class', 30);
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
            $table->integer('a_time')->nullable();
            $table->integer('b_time')->nullable();
            $table->integer('c_time')->nullable();
            $table->integer('d_time')->nullable();
            $table->integer('e_time')->nullable();
            $table->integer('f_time')->nullable();
            $table->integer('g_time')->nullable();
            $table->integer('h_time')->nullable();
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
