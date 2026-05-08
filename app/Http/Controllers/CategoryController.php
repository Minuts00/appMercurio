<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Categoria creata con successo.',
            'data' => $category,
        ], 201);
    }

    public function storeSubcategory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_category' => ['required', 'integer', 'exists:categories,id'],
        ]);

        $subcategory = Subcategory::create($validated);

        return response()->json([
            'message' => 'Sottocategoria creata con successo.',
            'data' => $subcategory,
        ], 201);
    }
}