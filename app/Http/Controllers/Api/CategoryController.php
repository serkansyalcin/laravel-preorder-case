<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = $this->categoryService->all();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'data' => $category,
            'message' => "Category listing."
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
        $slug = Str::slug(trim($request->name));
        $request->request->add(['slug' => $slug]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'slug' => 'required|unique:\App\Models\Category,slug'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $category = $this->categoryService->create([
            'name' => trim($request->name),
            'slug' => $slug
        ]);

        if (!$category) {
            return response()->json(['message' => 'Category not created'], 404);
        }

        return response()->json([
            'data' => $category,
            'message' => "Category created successfully."
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'data' => $category,
            'message' => "Category founds"
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
        $slug = Str::slug(trim($request->name));
        $request->request->add(['id' => $id]);
        $request->request->add(['slug' => $slug]);

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:\App\Models\Category,id',
            'name' => 'required|min:3|max:20',
            'slug' => 'required|unique:\App\Models\Category,slug,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $category = $this->categoryService->update([
            'name' => trim($request->name),
            'slug' => $slug
        ], $request->id);

        if (!$category) {
            return response()->json(['message' => 'Category not updated'], 404);
        }

        return response()->json([
            'data' => $category,
            'message' => "Category updated successfully."
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:\App\Models\Category,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 404);
        }

        $this->categoryService->delete($id);

        return response()->json([
            'data' => [],
            'message' => "Category deleted successfully."
        ], 200);
    }
}
