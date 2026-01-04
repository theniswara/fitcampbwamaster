<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribePackage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'icon',
        'name',
        'price',
        'duration',
    ];

    public function subscribeBenefits(): HasMany
    {
        return $this->hasMany(SubscribeBenefit::class);
    }
}
