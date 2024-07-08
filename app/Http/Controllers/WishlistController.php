<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Else_;

class WishlistController extends Controller
{
    //
    public function index()
    {

        //    
        $id = auth()->user()->id;

        if ($id) {

            //    
            $wishList = Wishlist::with('product')->where('user_id', $id)->paginate(10);

            if ($wishList) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Wishlist items displayed successfully',
                    'code' => 200,
                    'data' => $wishList
                ]);
            } else {
                return response()->json([
                    'type' => 'failure',
                    'message' => 'Wishlist items do not displayed successfully',
                    'code' => 404,
                ]);
            }
        }
    }





    public function toggle(Request $request,$productId)
    {
        
            $userId = auth()->user()->id;
           $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'type' => 'failure',
                    'message' => 'product Does Not Exist',
                    'code' => 404,
                ]);
            }


            // Check if the product is already in the wishlist
            $wishList = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

            if ($wishList) {
                // (remove from wishlist)
                $wishList->delete();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Wishlist item removed successfully',
                    'code' => 200,
                ]);
            } else {
                // If it does not exist, add it to the wishlist
                $wishList = Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
                return response()->json([
                    'type' => 'success',
                    'message' => 'Wishlist item added successfully',
                    'code' => 200,
                    'data' => $wishList
                ]);
            }
        } 
        
      
    

  

}