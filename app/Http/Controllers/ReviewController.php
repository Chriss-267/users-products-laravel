<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'products_id' => 'required|exists:products,id',
            'comment' => 'required|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de Validación',
                'errors' => $validator->errors()
            ], 400);
        }

        $review = new Reviews();
        $review->user_id = $request->input('user_id');
        $review->products_id = $request->input('products_id');
        $review->comment = $request->input('comment');
        $review->rating = $request->input('rating');
        $review->save();

        return response()->json(['message' => 'Reseña registrada exitosamente'], 201);
    }

    //Mostrando el promedio de valoraciones por solo un producto 
    public function averageRating($id)
    {
        $validator = Validator::make(['id'=>$id],[
            'id'=>'numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Error de validación',
                'errors'=>$validator->errors()
            ],400);
        }

        $average = Reviews::where('products_id', $id)->avg('rating');

        return response()->json(['average_rating' => $average], 200);
    }

    //Mostrando el promedio para cada producto
    public function averageRatingsPerProduct()
    {
        $results = Products::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.stock',
            'products.status',
            Reviews::raw('AVG(reviews.rating) as average_rating')
        )
        ->join('reviews', 'products.id', '=', 'reviews.products_id')
        ->groupBy('products.id', 'products.name', 'products.description', 'products.price', 'products.stock', 'products.status')
        ->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'No hay productos con valoraciones'], 404);
        }

        return response()->json([
            'data' => $results
        ], 200);
    }


    //Mostrando producto con la mejor valoración 
    public function bestRatedProduct()
    {
        $result = Products::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.stock',
            'products.status',
            Reviews::raw('AVG(reviews.rating) as average_rating')
        )
        ->join('reviews', 'products.id', '=', 'reviews.products_id')
        ->groupBy('products.id', 'products.name', 'products.description', 'products.price', 'products.stock', 'products.status')
        ->orderByDesc('average_rating')
        ->first();

        if (!$result) {
            return response()->json(['message' => 'No hay productos con valoraciones'], 404);
        }

        return response()->json([
            'data' => $result
        ], 200);
    }
}
