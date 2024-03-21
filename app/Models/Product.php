<?php

namespace App\Models;

use App\Trait\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UploadFile;

    protected $basePathImageable = 'product';
    protected $relatiunshipImageable = 'image' ;

    protected $fillable = [
        'name',
        'description',
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

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }
}
