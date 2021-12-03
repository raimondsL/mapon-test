<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AVLData extends Model
{
    protected $guarded = [];

    protected $casts = [
        'timestamp' => 'datetime',
        'gps_data' => 'array',
        'io_data' => 'array',
    ];

    use HasFactory;
}
