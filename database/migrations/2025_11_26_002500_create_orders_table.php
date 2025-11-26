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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->enum('status', ['pending', 'paid', 'processed', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('total_harga', 12, 2);
            $table->enum('metode_pembayaran', ['cod', 'transfer', 'ewallet']);
            $table->string('provinsi');
            $table->string('kota');
            $table->text('alamat_lengkap');
            $table->string('kode_pos', 10);
            $table->decimal('ongkir', 10, 2)->default(0);
            $table->text('catatan')->nullable();
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
