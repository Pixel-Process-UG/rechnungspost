<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integration extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'type', 'credentials_encrypted', 'active', 'last_synced_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'last_synced_at' => 'datetime',
    ];

    protected $hidden = ['credentials_encrypted'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
