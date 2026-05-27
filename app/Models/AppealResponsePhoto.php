<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppealResponsePhoto extends Model
{
    protected $fillable = [
        'appeal_id',
        'path',
        'uploaded_by',
    ];

    public function appeal(): BelongsTo
    {
        return $this->belongsTo(Appeal::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
