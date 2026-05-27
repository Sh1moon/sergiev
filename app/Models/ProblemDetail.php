<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProblemDetail extends Model
{
    protected $fillable = [
        'problem_subcategory_id',
        'name',
        'description',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(ProblemSubcategory::class, 'problem_subcategory_id');
    }

    public function appeals(): HasMany
    {
        return $this->hasMany(Appeal::class, 'problem_detail_id');
    }
}
