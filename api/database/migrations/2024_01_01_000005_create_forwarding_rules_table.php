<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forwarding_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('condition_type');
            $table->string('condition_value')->nullable();
            $table->string('action');
            $table->foreignId('target_integration_id')
                  ->nullable()
                  ->constrained('integrations')
                  ->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index('company_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forwarding_rules');
    }
};
