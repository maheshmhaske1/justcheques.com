<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'quantity',
        'color',
        'company_info',
        'voided_cheque',
        'institution_number',
        'transit_number',
        'account_number',
        'confirm_account_number',
        'cheque_start_number',
        'cheque_end_number',
        'cart_quantity',
        'cheque_category_id',
        'subcategory_id',
        'price',
        'voided_cheque_file',
        'company_logo',
        'vendor_id',
        'cheque_img',
        'order_status',
        'balance_status',
        'reorder',
        'signature_line',
        'logo_alignment',
    ];

    protected $casts = [
        'voided_cheque' => 'boolean',
        'reorder' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function chequeCategory()
    {
        return $this->belongsTo(ChequeCategories::class, 'cheque_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    // Helper method to get category name (works with both old and new system)
    public function getCategoryNameAttribute()
    {
        if ($this->subcategory_id && $this->subcategory) {
            // Get the first category for this subcategory
            $category = $this->subcategory->categories()->first();
            return $category ? $category->name : 'N/A';
        } elseif ($this->cheque_category_id && $this->chequeCategory) {
            // Old system fallback
            if ($this->chequeCategory->manual_cheque_id) {
                return 'Manual Cheques';
            } elseif ($this->chequeCategory->laser_cheque_id) {
                return 'Laser Cheques';
            } elseif ($this->chequeCategory->personal_cheque_id) {
                return 'Personal Cheques';
            }
        }
        return 'Unknown';
    }

    // Helper method to get subcategory name (works with both old and new system)
    public function getSubcategoryNameAttribute()
    {
        if ($this->subcategory_id && $this->subcategory) {
            return $this->subcategory->name;
        } elseif ($this->cheque_category_id && $this->chequeCategory) {
            return $this->chequeCategory->chequeName ?? 'Unknown';
        }
        return 'Unknown';
    }

    // Helper method to get price (works with both old and new system)
    public function getPriceAttribute($value)
    {
        // If price is stored directly, return it
        if ($value !== null) {
            return $value;
        }

        // Old system fallback
        if ($this->cheque_category_id && $this->chequeCategory) {
            return $this->chequeCategory->price ?? 0;
        }

        return 0;
    }
}
