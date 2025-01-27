<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Orders::all();
        return response()->json($orders, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'distributor_id' => 'required|exists:distributors,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processed,shipped,delivered'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $order = new Orders();
        $order->distributor_id = $request->input('distributor_id');
        $order->total_amount = $request->input('total_amount');
        $order->status = $request->input('status');
        $order->save();

        return response()->json(['message' => 'Orden registrada exitosamente'], 201);
    }

    public function show($id)
    {
        $order = Orders::find($id);
        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }
        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processed,shipped,delivered',
            'total_amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $order = Orders::find($id);
        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $order->status = $request->input('status');
        $order->total_amount = $request->input('total_amount');
        $order->save();

        return response()->json(['message' => 'Orden actualizada exitosamente'], 200);
    }

    public function destroy($id)
{
    $order = Orders::find($id);

    if (!$order) {
        return response()->json(['message' => 'Orden no encontrada'], 404);
    }

    $order->delete();

    return response()->json(['message' => 'Orden eliminada exitosamente'], 200);
}

}
