<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'cost',
        'price',
    ];

    protected function casts():array
    {
        return [
            'cost' => 'decimal:2',
            'price' => 'decimal:2',
        ];
    }
}
