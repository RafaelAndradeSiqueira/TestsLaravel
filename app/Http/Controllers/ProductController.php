<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exceptions\ProductTwoException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        return Product::create($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }


    public function add(Product $product)
    {
        session()->push('cart', $product->id);
        return response()->json(['message' => 'Product added to cart']);
    }

    public function productsInCart()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', $cart)->get();

        if(session()->has('cart') && count(session()->get('cart')) >= 3) {
            throw new ProductTwoException('Você não pode adicionar mais de 3 produtos ao carrinho.');
        }

        return response()->json($products);
    }



}
