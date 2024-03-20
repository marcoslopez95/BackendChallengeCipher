<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    const ADMIN = 1;
    const USER  = 2;

    public function getAdminModel(): Role
    {
        return $this->findOrFail(self::ADMIN);
    }

    public function getUserModel(): Role
    {
        return $this->findOrFail(self::USER);
    }
}
