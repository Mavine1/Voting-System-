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
            $table->text('items');  // Stores formatted items string (e.g., "galaxy s23 2 @ 1000, laptop 3 @6000")
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['ordered', 'processing', 'shipped', 'delivered'])->default('ordered');
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
