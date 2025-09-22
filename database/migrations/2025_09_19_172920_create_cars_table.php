<?php

use App\Enums\CarStatus;
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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id')->constrained('makes')->onDelete('cascade');
            $table->foreignId('model_id')->constrained('car_models')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('status')->default(CarStatus::Draft->value);
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('EUR');
            $table->boolean('featured')->default(false);
            $table->json('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'featured']);
            $table->index(['make_id', 'model_id']);
            $table->index(['price', 'currency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
