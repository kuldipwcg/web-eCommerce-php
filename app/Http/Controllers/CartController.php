<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    //list all cart with their  paginate by  10 items per page to items :-
    public function index(Request $request)
    {
        return response()->json(Cart::paginate(10));
    }

    public function store(cartRequest $request)
     {
    
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('/upload/cart/'), $imageName);
        $cartUrl = url('/upload/cart/' . $imageName);

        $cart = Cart::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'total' => $request->input('total'),
            'order_placed' => $request->input('order_placed', false),
            'image' => $cartUrl,
        ]);

        if ($cart) {
            return response()->json([
                'type' => 'success',
                'message' => 'cart data added successfully',
                'code' => 200,
                'data' => $cart
            ]);
            
    
        }
        else {
            return response()->json([
                'type' => 'failure',
                'message' => 'cart Data not added successfully',
                'code' => 404,
            ]);
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $cart = Cart::find($id);
        if (!$cart || $cart->user_id !== $user->id) {
            return response()->json(['error' => 'Cart item not found'], 422);
        }
        return response()->json($cart);
    }

    //method to update Cart
    public function update(CartRequest $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $cart = Cart::find($id);
        if (!$cart || $cart->user_id !== $user->id) {
            return response()->json(['error' => 'Cart not found'], 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = Storage::putFile('public/images', $image);
            $cart->image = Storage::url($imagePath);
        }

        $cart->update([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'total' => $request->input('total'),
            'order_placed' => $request->input('order_placed', false),
        ]);

        return response()->json($cart);
    }

    


    public function destroy(Request $request, $id)

    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $cart = Cart::find($id);
        if (!$cart || $cart->user_id !== $user->id) {
            return response()->json(['error' => 'Cart item not found'], 422);
        }
        $cart->update(['status' => 'inactive']); // soft delete
        return response()->json(['message' => 'Cart item deleted successfully']);
    }


}
