<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GymTestimonial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'occupation',
        'name',
        'photo',
        'message',
        'gym_id',
    ];
}
