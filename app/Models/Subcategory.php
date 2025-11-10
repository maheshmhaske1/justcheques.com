<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship: Many-to-Many with Categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_subcategory')
                    ->withPivot('display_order')
                    ->withTimestamps();
    }

    // Relationship: Has Many Pricing
    public function pricing()
    {
        return $this->hasMany(Pricing::class);
    }

    // Relationship: Many-to-Many with Colors
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_subcategory')
                    ->withTimestamps();
    }

    // Auto-generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subcategory) {
            if (empty($subcategory->slug)) {
                $subcategory->slug = Str::slug($subcategory->name);
            }
        });

        static::updating(function ($subcategory) {
            if ($subcategory->isDirty('name')) {
                $subcategory->slug = Str::slug($subcategory->name);
            }
        });
    }
}
