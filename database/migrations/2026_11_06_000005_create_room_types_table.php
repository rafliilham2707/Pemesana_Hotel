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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('max_guests')->default(2)->index();
            $table->string('bed_type')->default('1 Double Bed');
            $table->unsignedSmallInteger('size_m2')->nullable();
            $table->decimal('base_price', 14, 2)->unsigned()->index();
            $table->unsignedSmallInteger('total_rooms')->default(5);
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['hotel_id', 'base_price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
