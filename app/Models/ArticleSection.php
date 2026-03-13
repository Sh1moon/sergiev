<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleSection extends Model
{
    protected $fillable = ['slug', 'name', 'route_name', 'sort_order'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'article_section_id');
    }

    public static function slugNews(): string
    {
        return 'news';
    }
}
