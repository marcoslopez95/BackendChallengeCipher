<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $products = Product::with('image')->get();
        $currency = Currency::getPrincipalCurrency();
        return Inertia::render('Welcome', [
            'products' => $products,
            'currency' => $currency,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
