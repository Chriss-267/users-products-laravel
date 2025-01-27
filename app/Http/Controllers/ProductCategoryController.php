<?php

namespace App\Http\Controllers;

use App\Models\Product_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = Product_categories::all();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $category = new Product_categories();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return response()->json(['message' => 'Categoría registrada exitosamente'], 201);
    }

    public function show($id)
    {
        $category = Product_categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $category = Product_categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return response()->json(['message' => 'Categoría actualizada exitosamente'], 200);
    }

    public function destroy($id)
{
    $distributor = Product_categories::find($id);
    if (!$distributor) {
        return response()->json(['message' => 'Distribuidor no encontrado'], 404);
    }

    $distributor->delete();

    return response()->json(['message' => 'Distribuidor eliminado exitosamente'], 200);
}

}
