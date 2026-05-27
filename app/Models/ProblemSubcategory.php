<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProblemSubcategory extends Model
{
    protected $fillable = [
        'problem_category_id',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProblemCategory::class, 'problem_category_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ProblemDetail::class, 'problem_subcategory_id');
    }

    public function appeals(): HasMany
    {
        return $this->hasMany(Appeal::class, 'problem_subcategory_id');
    }
}
