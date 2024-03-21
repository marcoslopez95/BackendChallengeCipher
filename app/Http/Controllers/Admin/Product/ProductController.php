<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderByDesc('id')->get();
        return Inertia::render('Admin/Product/ProductView',[
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Product/ProductShow');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try{
            $product = Product::create($request->only([
                'name',
                'cost',
                'price',
            ]));

            return to_route('products.index');
        }catch(Exception $e){
            // dd($e->getMessage());
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('Admin/Product/ProductShow',[
            'product' => $product
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
    public function update(ProductRequest $request, Product $product)
    {
        try{
            $product->update($request->only([
                'name',
                'cost',
                'price',
            ]));

            return to_route('products.index');
        }catch(Exception $e){
            // dd($e->getMessage());
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product)
    {
        $product = Product::withTrashed()->find($product);

        $product->trashed()
        ? $product->restore()
        : $product->delete();

        return response()->noContent();
    }
}
