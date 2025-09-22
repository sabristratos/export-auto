<?php

use App\Enums\LeadStatus;
use App\Enums\LeadType;
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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->string('type')->default(LeadType::General->value);
            $table->string('status')->default(LeadStatus::New->value);
            $table->string('source')->nullable();
            $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('set null');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['type', 'status']);
            $table->index(['car_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
