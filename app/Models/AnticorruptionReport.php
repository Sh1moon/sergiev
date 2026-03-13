<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnticorruptionReport extends Model
{
    protected $table = 'anticorruption_reports';

    protected $fillable = [
        'user_id',
        'email',
        'body',
        'response',
        'responded_at',
        'responded_by',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function scopeNew($query)
    {
        return $query->whereNull('responded_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('responded_at');
    }
}
