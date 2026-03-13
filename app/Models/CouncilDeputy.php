<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CouncilDeputy extends Model
{
    protected $fillable = ['photo', 'name', 'info', 'contacts', 'sort_order'];

    public function photoUrl(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function initials(): string
    {
        $words = preg_split('/\s+/u', trim($this->name), 3);
        if (count($words) >= 3) {
            return mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1) . mb_substr($words[2], 0, 1);
        }
        return Str::upper(mb_substr($this->name, 0, 3));
    }
}
