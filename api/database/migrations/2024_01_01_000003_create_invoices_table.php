<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('sender_name')->nullable();
            $table->string('sender_vat_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('amount_net', 12, 2)->nullable();
            $table->decimal('amount_gross', 12, 2)->nullable();
            $table->decimal('vat_amount', 12, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->string('format')->default('xrechnung-ubl');
            $table->string('status')->default('received');
            $table->longText('raw_xml')->nullable();
            $table->string('raw_pdf_path')->nullable();
            $table->jsonb('parsed_dto')->nullable();
            $table->jsonb('validation_report')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();

            $table->index('company_id');
            $table->index('status');
            $table->index('received_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
