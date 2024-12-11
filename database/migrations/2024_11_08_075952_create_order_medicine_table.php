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
        Schema::create('order_medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi ke tabel orders
            $table->foreignId('medicine_id')->constrained()->onDelete('cascade'); // Relasi ke tabel medicines
            $table->decimal('price', 8, 2); // Harga obat pada saat transaksi
            $table->decimal('sub_price', 8, 2); // Harga per obat x qty
            $table->integer('qty'); // Jumlah obat yang dibeli
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_medicine');
    }
};
