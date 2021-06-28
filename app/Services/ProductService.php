<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductService
{
    /**
     *  Create the product
     */
    public function storeProduct(Request $request)
    {
        return Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price
        ]);
    }

    /**
     *  Update product
     */
    public function updateProduct(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return $product;
    }

    /**
     *  Delete product
     */
    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
    }
}
