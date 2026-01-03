<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gym extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'name',
        'slug',
        'address',
        'about',
        'is_popular',
        'open_time_at',
        'closed_time_at',
        'city_id',
    ];
}
