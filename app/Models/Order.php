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
        'voided_cheque_file',
        'company_logo',
        'vendor_id',
        'cheque_img',
        'order_status',
        'balance_status',
        'reorder',
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
}
