<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationDepartment extends Model
{
    protected $fillable = ['management_name', 'head_text', 'schedule_text', 'body', 'sort_order'];
}
