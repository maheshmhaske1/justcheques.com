<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name',
        'value',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship: Many-to-Many with Subcategories
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'color_subcategory')
                    ->withTimestamps();
    }
}
