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
        Schema::create('expenses_income', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['income', 'expense']);
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan');
            $table->date('tanggal');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses_income');
    }
};
