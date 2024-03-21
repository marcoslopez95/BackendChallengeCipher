<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try{
            $product = Product::create($request->only([
                'name',
                'cost',
                'price',
            ]));

            $product->upload(
                $request->image,
                $product->id
            );
            DB::commit();
            return to_route('products.index');
        }catch(Exception $e){
            DB::rollBack();
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
        $product->load('image');
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
        DB::beginTransaction();
        try{
            $product->update($request->only([
                'name',
                'cost',
                'price',
            ]));

            if($request->hasFile('image')){
                $product->deleteFile($product->image->path);
                $product->image->delete();
                $product->upload(
                    $request->image,
                    $product->id
                );
            }

            DB::commit();
            return to_route('products.index');
        }catch(Exception $e){
            DB::rollBack();
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
        DB::beginTransaction();
        try{
            $product = Product::withTrashed()->find($product);

            $product->trashed()
            ? $product->restore()
            : $product->delete();
            DB::commit();

            return response()->noContent();
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
