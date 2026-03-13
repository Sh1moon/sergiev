<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HonoraryCitizen extends Model
{
    protected $fillable = ['category', 'person_name', 'person_info', 'awarded_by', 'sort_order'];
}
