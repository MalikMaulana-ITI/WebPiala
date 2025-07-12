<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trophy extends Model
{
    protected $fillable = [
        "name",
        "material_id",
        "text",
        "color",
        "image",
        "price",
    ];

    public function trophyMaterial(): BelongsTo {
        return $this->belongsTo(TrophyMaterial::class, 'material_id');
    }

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }
}
