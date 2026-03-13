<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationTerritory extends Model
{
    protected $fillable = ['management', 'leader', 'contacts', 'address', 'sort_order'];
}
