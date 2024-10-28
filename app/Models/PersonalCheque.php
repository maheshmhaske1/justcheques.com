<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCheque extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoriesName',
        'img',
    ];
}
