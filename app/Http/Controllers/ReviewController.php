<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;


class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user','product'])->get();
        return response()->json([
            "reviews" => $reviews,
            'status'=> 200
        ],200);
    }

    public function store(ReviewRequest $request)
    {
        $userId = auth()->user()->id;
        $productId = Product::where('id', $request->product_id)->first();

        $existReview = Review::where('user_id', $userId)->where('product_id', $productId)->first();
        if($existReview){
            return response()->json([
                'Message'=>'Review is already available from user',
                'status'=> 200
            ],200);
        }

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => $userId,
            'rating' => $request->rating,
            'review' => $request->review
        ]);
        return response()->json([
            "review" => $review,
            'status'=> 200
        ],200);
    }

    public function update(ReviewRequest $request,$id){
        $review = Review::find($id);
        if(!$review){
            return response()->json([
                'Message' => "Review data is not available.",
                'Status' => 200,
            ], 200);
        }
        $review->update($request->all());
        return response()->json([
            'Message' => "Review Updated Successfully.",
            'status'=> 200
        ],200);
    }

    public function destroy($id){
        $review = Review::find($id);
        if(!$review){
            return response()->json([
                'Message' => "Review data is not available.",
                'status' => 200,
            ], 200);
        }
        $review->delete();
        return response()->json([
            'Message' => "Review Deleted Successfully.",
            'status' => 200,
        ],200);
    }
}
