<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Models\Wishlist;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use PhpParser\Node\Stmt\Else_;

class WishlistController extends Controller
{
    //
    public function index()
    {

    $Wishlist = Wishlist::latest()->paginate(10);
    $wishlist=Wishlist::with('Category')->latest()->paginate(10);
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
public function store(WishlistRequest $request)
{ 
    $Wishlist = Wishlist::create([
        'user_id' => $request->user_id,
        'product_id' => $request->product_id,
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

public function destroy(){
    $wishlist = auth()->user();
    $wishlist->delete();
    
    if ($wishlist) {
        // return response()->json(['error' => 'wishlist not deleted'], 404);
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

}