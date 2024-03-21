<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'fixed',
        'percentage',
        'name',
    ];

    protected function casts():array
    {
        return [
            'fixed' => 'int',
            'percentage' => 'int',
        ];
    }
}
