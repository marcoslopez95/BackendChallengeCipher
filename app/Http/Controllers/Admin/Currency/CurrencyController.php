<?php

namespace App\Http\Controllers\Admin\Currency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CurrencyRequest;
use App\Models\Currency;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::orderByDesc('id')->get();
        return Inertia::render('Admin/CurrencyView',[
            'currencies' => $currencies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/CurrencyShow');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request)
    {
        try{
            $currency = Currency::create($request->only([
                'name',
                'abbreviation',
                'symbol',
                'exchange',
                'principal',
            ]));

            return to_route('currencies.index');
        }catch(Exception $e){
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return Inertia::render('Admin/CurrencyShow',[
            'currency' => $currency
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        try{
            $currency->update($request->only([
                'name',
                'abbreviation',
                'symbol',
                'exchange',
                'principal',
            ]));

            return to_route('currencies.index');
        }catch(Exception $e){
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $currency)
    {
        $currency = Currency::withTrashed()->find($currency);

        $currency->trashed()
        ? $currency->restore()
        : $currency->delete();

        return response()->noContent();
    }
}