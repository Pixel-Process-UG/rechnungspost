<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'sender_name', 'sender_vat_id', 'invoice_number',
        'date', 'due_date', 'amount_net', 'amount_gross', 'vat_amount',
        'currency', 'format', 'status', 'raw_xml', 'raw_pdf_path',
        'parsed_dto', 'validation_report', 'received_at',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'received_at' => 'datetime',
        'amount_net' => 'decimal:2',
        'amount_gross' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'parsed_dto' => 'array',
        'validation_report' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
