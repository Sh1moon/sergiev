<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleFile extends Model
{
    protected $fillable = ['article_id', 'original_name', 'path'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
