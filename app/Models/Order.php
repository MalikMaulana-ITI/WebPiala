<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $primaryKey = "order_id";
    protected $fillable = [
        "buyer_name",
        "phone_number",
        "email",
        "trophy_id",
        "isCustomize",
        "customize_id",
        "order_status",
        "shipping_address",
        "village_name",
        "district_name",
        "regency_name",
        "province_name",
    ];

    public function trophy(): BelongsTo {
        return $this->belongsTo(Trophy::class, 'trophy_id', 'id');
    }

    public function customize(): BelongsTo {
        return $this->belongsTo(CustomizeTrophy::class, 'customize_id', 'id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'order_id', 'order_id');
    }
    
}
