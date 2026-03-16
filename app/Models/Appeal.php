<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appeal extends Model
{
    protected $fillable = [
        'user_id',
        'fio',
        'postal_address',
        'email',
        'phone',
        'body',
        'attachment',
        'consent',
        'ip_address',
        'response',
        'responded_at',
        'responded_by',
    ];

    protected function casts(): array
    {
        return [
            'consent' => 'boolean',
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

    public function isImageAttachment(): bool
    {
        if (!$this->attachment) {
            return false;
        }
        $ext = strtolower(pathinfo($this->attachment, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    }

    public function attachmentOriginalName(): string
    {
        return $this->attachment ? basename($this->attachment) : '';
    }
}
