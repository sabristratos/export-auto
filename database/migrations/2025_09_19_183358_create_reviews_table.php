<?php

use App\Enums\ReviewStatus;
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_location')->nullable();
            $table->json('content');
            $table->tinyInteger('rating')->default(5);
            $table->string('status')->default(ReviewStatus::Pending->value);
            $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('set null');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['car_id', 'status']);
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
