<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcategoryItem extends Model
{
    protected $fillable = [
        'subcategory_id',
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship: Belongs to Subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
