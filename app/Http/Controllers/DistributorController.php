<?php

namespace App\Http\Controllers;

use App\Models\Distributors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributors::all();
        return response()->json($distributors, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:distributors,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $distributor = new Distributors();
        $distributor->name = $request->input('name');
        $distributor->email = $request->input('email');
        $distributor->phone = $request->input('phone');
        $distributor->address = $request->input('address');
        $distributor->status = $request->input('status');
        $distributor->save();

        return response()->json(['message' => 'Distribuidor registrado exitosamente'], 201);
    }

    public function show($id)
    {
        $distributor = Distributors::find($id);
        if (!$distributor) {
            return response()->json(['message' => 'Distribuidor no encontrado'], 404);
        }
        return response()->json($distributor, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:distributors,email,' . $id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $distributor = Distributors::find($id);
        if (!$distributor) {
            return response()->json(['message' => 'Distribuidor no encontrado'], 404);
        }

        $distributor->name = $request->input('name');
        $distributor->email = $request->input('email');
        $distributor->phone = $request->input('phone');
        $distributor->address = $request->input('address');
        $distributor->status = $request->input('status');
        $distributor->save();

        return response()->json(['message' => 'Distribuidor actualizado exitosamente'], 200);
    }

    public function destroy($id)
{
    $product = Distributors::find($id);
    if (!$product) {
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    $product->delete();

    return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
}

}
