<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'abbreviation',
        'symbol',
        'exchange',
        'principal',
    ];

    public function casts():array
    {
        return [
            'principal' => 'boolean',
            'exchange'  => 'decimal:2',
        ];
    }

    protected static function booted():void
    {
        $removeLatestPrincipal = function(Currency $new_currency_principal){
            if(!$new_currency_principal->principal) return;
            Currency::where([
                ['principal',true],
                ['id','<>',$new_currency_principal->id]
                ])->update([
                    'principal' => false
                ]);
        };

        static::created(function(Currency $currency) use ($removeLatestPrincipal){
            $removeLatestPrincipal($currency);
        });

        $verifiedExistPrincipal = function(Currency $currency){
            $principalExists = Currency::where([
                ['principal',true],
                ['id','<>',$currency->id]
                ])->first();
            if(!$currency->principal && !$principalExists){
                $currency->principal = true;
                $currency->saveQuietly();
            }else{
                $principalExists->principal = false;
                $principalExists->saveQuietly();
            }
        };
        static::updating(function(Currency $currency) use ($verifiedExistPrincipal){
            $verifiedExistPrincipal($currency);
        });
    }

    public static function getPrincipalCurrency():Currency
    {
        return self::where('principal',true)->first();
    }
}
