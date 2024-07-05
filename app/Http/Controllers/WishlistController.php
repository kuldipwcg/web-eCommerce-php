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
//     public function index()
// {

//     // $id = auth()->user()->id;

//     // if($id){

// //    
//     $Wishlist=Wishlist::with('product')->latest()->paginate(10);

//     if ($Wishlist) {
//         return response()->json([
//             'type' => 'success',
//             'message' => 'Wishlist items displayed successfully',
//             'code' => 200,
//             'data' => $Wishlist
//         ]);
//     } else {
//         return response()->json([
//             'type' => 'failure',
//             'message' => 'something went wrong',
//             'code' => 404,
//         ]);
//     }
// //}
// }
public function store(Request $request,$product_id)
{ 

    try{ 
        $id = auth()->user()->id;
        
        if($id){
            $Wishlist = Wishlist::create([
                'user_id' => $id,
                'product_id' => $product_id,
            ]);
            if ($Wishlist) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'data added successfully',
                    'code' => 200,
                    'data' => $Wishlist
                ]);
                
        
            }
            else {
                return response()->json([
                    'type' => 'failure',
                    'message' => 'Data not added successfully',
                    'code' => 404,
                ]);
            }
        }

        else
        {
            return response()->json([
                'type' => 'failure',
                'message' => 'Data not added successfully',
                'code' => 402,
            ]);
        }
  

}
catch (QueryException $e) {
    if ($e->getCode() == 23000) { // Integrity constraint violation code for MySQL
        return response()->json([
            'error' => 'Duplicate entry: The product is already in your wishlist'
        ], 409); // Conflict status code
    }
    return response()->json([
        'error' => 'Something went wrong'
    ], 500);
}
}


public function destroy(){
    
    $id = auth()->user()->id;
    dd($id);
    // dd($id);
    // $id->delete();
    // $Wishlist=Wishlist::where('user_id',$id);
    $Wishlist=Wishlist::get();
    dd($Wishlist);
    // $products = Product::latest('id')->get();

    if ($Wishlist->delete()) {
        return response()->json([
            'type' => 'success',
            'message' => 'Wishlist detail deleted successfully',
            'code' => 200,
        ]);
    }

    else
    {
        return response()->json([
            'type' => 'failure',
            'message' => 'Wishlist detail not deleted successfully',
            'code' => 404,
        ]);
    }
 
    
}

public function show()
{
    $id = auth()->user()->id;

    if($id){

//    
    $Wishlist=Wishlist::with('product')->where('user_id',$id)->paginate(10);

    if ($Wishlist) {
        return response()->json([
            'type' => 'success',
            'message' => 'Wishlist items displayed successfully',
            'code' => 200,
            'data' => $Wishlist
        ]);
    } else {
        return response()->json([
            'type' => 'failure',
            'message' => 'something went wrong',
            'code' => 404,
        ]);
    }
}
}
}