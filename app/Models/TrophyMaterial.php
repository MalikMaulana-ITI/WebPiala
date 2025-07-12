<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrophyMaterial extends Model
{
    protected $fillable = [
        'material_name',
        'price',
    ];


    public function trophy(): HasMany {
        return $this->hasMany(Trophy::class);
    }
}
