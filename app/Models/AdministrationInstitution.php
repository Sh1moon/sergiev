<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationInstitution extends Model
{
    protected $fillable = ['title', 'leader', 'address', 'phones', 'email', 'website', 'description', 'sort_order'];
}
