<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Track which batches were consumed in each sale detail (FIFO)
        Schema::create('sale_detail_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_detail_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_batch_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity_taken');
            $table->decimal('purchase_price', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_detail_batches');
    }
};
