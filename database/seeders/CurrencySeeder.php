<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::firstOrCreate([
            'name' => 'Dólar',
            'abbreviation' => 'USD',
            'symbol' => '$',
            'exchange' => 1,
            'principal' => true,
        ]);

        Currency::firstOrCreate([
            'name' => 'Bolívares',
            'abbreviation' => 'VES',
            'symbol' => 'Bs',
            'exchange' => 37,
            'principal' => false,
        ]);
    }
}
