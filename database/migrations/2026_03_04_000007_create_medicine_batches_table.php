<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number');
            $table->date('expired_date');
            $table->decimal('purchase_price', 12, 2);
            $table->integer('initial_quantity');
            $table->integer('remaining_quantity');
            $table->foreignId('purchase_detail_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['medicine_id', 'expired_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_batches');
    }
};
