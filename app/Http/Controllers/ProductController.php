<?php

namespace App\Http\Controllers;


use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'distributor_id' => 'required|exists:distributors,id',
            'status' => 'required|in:available,out_of_stock,discontinued'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $product = new Products();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->category_id = $request->input('category_id');
        $product->distributor_id = $request->input('distributor_id');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['message' => 'Producto registrado exitosamente'], 201);
    }

    public function show($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json($product, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,out_of_stock,discontinued'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['message' => 'Producto actualizado exitosamente'], 200);
    }

    public function destroy($id)
{
    $product = Products::find($id);
    if (!$product) {
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    $product->delete();

    return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
}

    
}