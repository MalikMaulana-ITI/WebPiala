<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomizeTrophy extends Model
{
    protected $fillable = [
        "customize",
    ];

    protected $casts = [
        'customize' => 'array',
    ];

    public function orders(): HasMany {
        return $this->hasMany(Order::class, 'customize_id');
    }

    public function neworder(): HasOne {
        return $this->hasOne(Order::class, 'customize_id');
    }
}
