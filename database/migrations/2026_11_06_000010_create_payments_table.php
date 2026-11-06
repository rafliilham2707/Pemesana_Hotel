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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('method')->default('midtrans'); // 'midtrans', 'bank_transfer', 'credit_card', 'qris', 'e_wallet'
            $table->string('provider_reference')->nullable()->index();
            $table->decimal('amount', 14, 2);
            $table->string('status')->default('pending')->index(); // 'pending', 'paid', 'failed', 'expired', 'refunded'
            $table->timestamp('paid_at')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
