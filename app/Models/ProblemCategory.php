<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProblemCategory extends Model
{
    protected $fillable = [
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

    public function appeals(): HasMany
    {
        return $this->hasMany(Appeal::class, 'problem_category_id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(ProblemSubcategory::class, 'problem_category_id');
    }
}
