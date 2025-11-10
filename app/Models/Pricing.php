<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $table = 'pricing';

    protected $fillable = [
        'subcategory_id',
        'quantity_tier_id',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationship: Belongs to Subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Relationship: Belongs to QuantityTier
    public function quantityTier()
    {
        return $this->belongsTo(QuantityTier::class);
    }
}
