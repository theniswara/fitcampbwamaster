<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected function subscribePackage(): BelongsTo
    {
        return $this->belongsTo(SubscribePackage::class, 'subscribe_package_id');
    }

    public static function generateUniqueTrxId()
    {
        $prefix = 'FITBWA';
        do {
            $randomstring = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomstring)->exists());

        return $randomstring;
    }
}
