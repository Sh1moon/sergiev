<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationHead extends Model
{
    protected $fillable = ['photo', 'title', 'description'];

    public function photoUrl(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function initials(): string
    {
        $words = preg_split('/\s+/u', trim($this->title), 4);
        if (count($words) >= 3) {
            return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1) . mb_substr($words[2], 0, 1));
        }
        return mb_strtoupper(mb_substr($this->title, 0, 3));
    }
}
