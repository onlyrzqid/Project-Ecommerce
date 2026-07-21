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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        // Menghubungkan produk ke kategori. Jika kategori dihapus, produk di dalamnya otomatis ikut terhapus
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
        $table->string('nama'); // Nama Laptop/Aksesoris
        $table->bigInteger('harga');
        $table->integer('stok');
        $table->string('foto')->nullable(); // Tempat menyimpan path file foto produk
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
