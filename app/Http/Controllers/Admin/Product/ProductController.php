<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Tax;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
        $taxes = Tax::all();
        return Inertia::render('Admin/Product/ProductEdit',[
            'taxes' => $taxes
        ]);
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
        $taxes = Tax::all();
        $product->load('image');
        $currency = Currency::getPrincipalCurrency();
        return Inertia::render('Admin/Product/ProductShow',[
            'taxes' => $taxes,
            'product' => $product,
            'currency' => $currency,
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
            'laravelVersion' => \Illuminate\Foundation\Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ])->with([
            'notification' => Session::get('notification'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('image');
        $currency = Currency::getPrincipalCurrency();
        return Inertia::render('Admin/Product/ProductEdit',[
            'product' => $product,
            'currency' => $currency,
        ]);
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

    public function addShoppingCart(Product $product, Request $request)
    {
        $data = collect(Session::get('ShoppingCart',[]));
        $productInShoppingCart = $data->firstWhere('product_id', $product->id);
        if(!$productInShoppingCart){
            $productInShoppingCart = [
                'product' => $product->only('name','id','price'),
                'quantity'   => 1
            ];
            $newData = $data->push((array) $productInShoppingCart)->toArray();
        }else{
            $productInShoppingCart['quantity'] += $request->quantyty ?? 1;
            $newData = $data->whereNotIn('product_id', [$product->id])
                        ->push($productInShoppingCart)
                        ->toArray();
        }
        Session::put('ShoppingCart',$newData);
        Session::flash('notification',[
            'type' => 'success',
            'message' => 'Añadido exitosamente'
        ]);
        // dd($product);

        return back();
    }
}
