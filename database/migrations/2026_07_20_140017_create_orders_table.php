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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemilik pesanan
        $table->string('kode_transaksi')->unique(); // Kode unik (misal: TRX-AB12CD34)
        $table->bigInteger('total_harga'); // Total bayar seluruh barang
        $table->string('nama_penerima');
        $table->string('no_hp');
        $table->text('alamat_pengiriman');
        $table->string('metode_pembayaran')->default('Transfer Bank');
        $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
