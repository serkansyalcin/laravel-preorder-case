<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = $this->productService->all();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'data' => $product,
            'message' => "Product listing."
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:\App\Models\Category,id',
            'name' => 'required|min:3|max:20|unique:\App\Models\Product,name',
            'sku' => 'required|unique:\App\Models\Product,sku',
            'price' => 'required|numeric|gt:0',
            'image' => 'image|mimes:jpg,jpeg,png,gif,svg|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products');
        }

        $product = $this->productService->create([
            'name' => trim($request->name),
            'sku' => trim($request->sku),
            'category_id' => trim($request->category_id),
            'price' => trim($request->price),
            'image' => $image_path,
        ]);

        if (!$product) {
            return response()->json(['message' => 'Product not created'], 404);
        }

        return response()->json([
            'data' => $product,
            'message' => "Product created successfully."
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'data' => $product,
            'message' => "Product founds"
        ], 200);
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
    public function update(Request $request, string $id)
    {
        $request->request->add(['id' => $id]);

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:\App\Models\Product,id',
            'category_id' => 'required|exists:\App\Models\Category,id',
            'name' => 'required|min:3|max:20|unique:\App\Models\Product,name,' . $id,
            'sku' => 'required|unique:\App\Models\Product,sku,' . $id,
            'price' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $products = Product::findOrFail($id);

        
        $image_path = '';
        
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products');
            if ($products->image) {
                Storage::delete($products->image);
            }
        }

        $product = $this->productService->update([
            'name' => trim($request->name),
            'sku' => trim($request->sku),
            'category_id' => trim($request->category_id),
            'price' => trim($request->price),
            'image' => $image_path,
        ], $id);

        if (!$product) {
            return response()->json(['message' => 'Product not updated'], 404);
        }

        return response()->json([
            'data' => $product,
            'message' => "Product updated successfully."
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:\App\Models\Product,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $this->productService->delete($id);

        return response()->json([
            'data' => [],
            'message' => "Product deleted successfully."
        ], 200);
    }
}
