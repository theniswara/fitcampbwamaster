<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribeTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'booking_trx_id',
        'name',
        'phone',
        'email',
        'proof',
        'total_amount',
        'duration',
        'is_paid',
        'started_at',
        'ended_at',
        'subcribe_package_id',
    ];

    protected $cast = [
        'started_at' => 'date',
        'ended_at' => 'date',
    ];
}
