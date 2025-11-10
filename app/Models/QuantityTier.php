<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuantityTier extends Model
{
    protected $fillable = [
        'quantity',
        'display_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quantity' => 'integer',
        'display_order' => 'integer',
    ];

    // Relationship: Has Many Pricing
    public function pricing()
    {
        return $this->hasMany(Pricing::class);
    }
}
