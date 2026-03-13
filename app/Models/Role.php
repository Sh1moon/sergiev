<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public const ADMIN = 'admin';
    public const EMPLOYEE = 'employee';
    public const USER = 'user';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public static function getRoleId(string $slug): ?int
    {
        return self::where('slug', $slug)->value('id');
    }
}