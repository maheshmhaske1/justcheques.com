<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeCategories extends Model
{
    use HasFactory;
    protected $table = 'cheque_categories';
    protected $fillable = [
        'manual_cheque_id',
        'laser_cheque_id',
        'chequeName',
        'price',
        'img',
    ];
}
