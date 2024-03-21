<?php

namespace App\Http\Controllers\Admin\Tax;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxRequest;
use App\Models\Tax;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taxes = Tax::withTrashed()->get();
        return Inertia::render('Admin/Tax/TaxView',[
            'taxes' => $taxes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Tax/TaxShow');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxRequest $request)
    {
        try{
            $tax = Tax::create($request->only([
                'name',
                'fixed',
                'percentage',
            ]));

            return to_route('taxes.index');
        }catch(Exception $e){
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        return Inertia::render('Admin/Tax/TaxShow', [
            'tax' => $tax
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
    public function update(TaxRequest $request, Tax $tax)
    {
        try{
            $tax->update($request->only([
                'name',
                'fixed',
                'percentage',
            ]));

            return to_route('taxes.index');
        }catch(Exception $e){
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $currency)
    {
        $tax = Tax::withTrashed()->find($currency);

        $tax->trashed()
        ? $tax->restore()
        : $tax->delete();

        return response()->noContent();
    }
}
