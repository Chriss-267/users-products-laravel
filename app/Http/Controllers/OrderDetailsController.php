<?php

namespace App\Http\Controllers;

use App\Models\Order_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDetailsController extends Controller
{
    public function index()
    {
        $orderDetails = Order_details::all();
        return response()->json($orderDetails, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }
    
        $orderDetail = new Order_details();
        $orderDetail->order_id = $request->input('order_id');
        $orderDetail->product_id = $request->input('product_id');
        $orderDetail->quantity = $request->input('quantity');
        $orderDetail->unit_price = $request->input('unit_price');
        // Elimina la línea que intenta asignar 'subtotal'
        $orderDetail->save();
    
        return response()->json(['message' => 'Detalle de orden registrado exitosamente'], 201);
    }
    
    public function show($id)
    {
        $orderDetail = Order_details::find($id);
        if (!$orderDetail) {
            return response()->json(['message' => 'Detalle de orden no encontrado'], 404);
        }
        return response()->json($orderDetail, 200);
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'quantity' => 'required|integer|min:1',
        'unit_price' => 'required|numeric|min:0',
        // Elimina la validación para 'subtotal'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Error de Validación',
            'errors' => $validator->errors()
        ], 400);
    }

    $orderDetail = Order_details::find($id);
    if (!$orderDetail) {
        return response()->json(['message' => 'Detalle de orden no encontrado'], 404);
    }

    $orderDetail->quantity = $request->input('quantity');
    $orderDetail->unit_price = $request->input('unit_price');
    // Elimina la asignación para 'subtotal'
    $orderDetail->save();

    return response()->json(['message' => 'Detalle de orden actualizado exitosamente'], 200);
}

    public function destroy($id)
    {
        $orderDetail = Order_details::find($id);
        if (!$orderDetail) {
            return response()->json(['message' => 'Detalle de orden no encontrado'], 404);
        }

        $orderDetail->delete();
        return response()->json(['message' => 'Detalle de orden eliminado exitosamente'], 200);
    }

    public function getByOrder($orderId)
    {
        $orderDetails = Order_details::where('order_id', $orderId)->get();
        if ($orderDetails->isEmpty()) {
            return response()->json(['message' => 'No se encontraron detalles para esta orden'], 404);
        }
        return response()->json($orderDetails, 200);
    }
}