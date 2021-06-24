<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     *  Store a product
     * 
     *  @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        //  Create the product
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price
        ]);

        // We want to return the product with a 201 status code
        return response()->json(new ProductResource($product), 201);
    }

    /**
     *  Show a product
     * 
     *  @param int $id product id
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        return response()->json(new ProductResource($product));
    }
}
