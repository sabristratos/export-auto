<?php

use App\Enums\AttributeType;
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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->string('type')->default(AttributeType::Text->value);
            $table->string('unit')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(true);
            $table->boolean('is_searchable')->default(false);
            $table->integer('display_order')->default(0);
            $table->string('group')->nullable();
            $table->json('description')->nullable();
            $table->timestamps();

            $table->index(['is_filterable', 'display_order']);
            $table->index(['group', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
