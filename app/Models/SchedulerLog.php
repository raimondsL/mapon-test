<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulerLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function lastOffset()
    {
        return self::latest('id')->value('offset') ?? 0;
    }
}
