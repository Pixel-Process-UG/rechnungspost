<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForwardingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'condition_type', 'condition_value', 'action',
        'target_integration_id', 'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function targetIntegration(): BelongsTo
    {
        return $this->belongsTo(Integration::class, 'target_integration_id');
    }
}
