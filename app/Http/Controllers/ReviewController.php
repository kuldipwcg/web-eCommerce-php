<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user','product'])->get();
        return response()->json([
            "Review" => $reviews
        ]);
    }

    public function store(Request $request)
    {
        $userid = User::where('id', $request->user_id)->first();
        $productid = Product::where('id', $request->product_id)->first();

        $existReview = Review::where('user_id', $userid)->where('product_id', $productid)->first();
        if($existReview){
            return response()->json([
                'Message'=>'Review is already available from user',
                'status'=> 403
            ],403);
        }

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);
        return response()->json($review);
    }

    public function update(Request $request,$id){
        $review = Review::find($id);
        if(!$review){
            return response()->json([
                'Message' => "Review Not Found.",
                'Status' => 404,
            ], 404);
        }
        $review->update($request->all());
        return response()->json([
            'Message' => "Review Updated Successfully.",
        ],200);
    }

    public function destroy($id){
        $review = Review::find($id);
        if(!$review){
            return response()->json([
                'Message' => "Review Not Found.",
                'Status' => 404,
            ], 404);
        }
        $review->delete();
        return response()->json([
            'Message' => "Review Deleted Successfully.",
        ],200);
    }

}
