<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictPoliceEntry extends Model
{
    protected $fillable = [
        'sort_order',
        'admin_district',
        'responsible',
        'substitute',
        'residential_sector',
        'reception_days',
        'leadership_reception_days',
        'reception_place',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
