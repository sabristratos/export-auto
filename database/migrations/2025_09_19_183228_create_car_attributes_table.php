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
        Schema::create('car_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade');
            $table->text('value');
            $table->timestamps();

            $table->unique(['car_id', 'attribute_id']);
            $table->index(['attribute_id', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_attributes');
    }
};
