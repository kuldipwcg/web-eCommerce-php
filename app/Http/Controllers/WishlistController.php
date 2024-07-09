<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
class WishlistController extends Controller
{
    //
    public function index()
    {
        //   
          $id = auth()->user()->id;
            //    
            $wishList = Wishlist::with('product')->where('user_id', $id)->paginate(10);

            if ($wishList) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Wishlist items displayed successfully',
                    'code' => 200,
                    'data' => $wishList
                ]);
            } 
            
            else {
                return response()->json([
                    'type' => 'failure',
                    'message' => 'Wishlist do not have items',
                    'code' => 200,
                ]);
            }
        }

    public function toggle(Request $request,$productId)
    {
            $id  = auth()->user()->id;
           $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'type' => 'failure',
                    'message' => 'Product does not exist',
                    'code' => 200,
                ]);
            }


            // Check if the product is already in the wishlist
            $wishList = Wishlist::where('user_id', $id)->where('product_id', $productId)->first();

            if ($wishList) {
                // (remove from wishlist)
                $wishList->delete();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Item removed from wishlist',
                    'code' => 200,
                ]);
            }
            
            else {
                // If it does not exist, add it to the wishlist
                $wishList = Wishlist::create([
                    'user_id' => $id,
                    'product_id' => $productId,
                ]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Item added to wishlist',
                    'code' => 200,
                    'data' => $wishList
                ]);
            }
        } 
}