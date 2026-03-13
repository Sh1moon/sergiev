<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementCompanyRow extends Model
{
    protected $fillable = ['section', 'num', 'content', 'sort_order'];
}
