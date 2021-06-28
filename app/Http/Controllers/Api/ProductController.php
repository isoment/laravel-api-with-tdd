<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     *  Product Index
     */
    public function index()
    {
        // We dont need to use response()->json() since we are not changing the status code
        return new ProductCollectionResource(Product::paginate());
    }

    /**
     *  Store a product
     * 
     *  @param Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        // Store the product
        $product = $this->productService->storeProduct($request);

        // We want to return the product with a 201 status code
        return response()->json(new ProductResource($product), 201);
    }

    /**
     *  Show a product
     * 
     *  @param int product $id
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        return response()->json(new ProductResource($product));
    }

    /**
     *  Update a product
     * 
     *  @param Illuminate\Http\Request
     *  @param int product $id
     */
    public function update(Request $request, int $id)
    {
        $product = $this->productService->updateProduct($request, $id);

        return response()->json(new ProductResource($product));
    }

    /**
     *  Delete a product
     * 
     *  @param int product $id
     */
    public function destroy(int $id)
    {
        $this->productService->deleteProduct($id);

        return response()->json(null, 204);
    }
}
