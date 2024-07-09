<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //list all cart with their  paginate by  10 items per page to items :-
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(
            Cart::where('status', 'active')
                ->where('user_id', $user->id)
                ->get(),
        );
    }

    // Store a newly created cart
    public function store(CartRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'status' => 'active', // default status is active
            'order_placed' => $request->input('order_placed', false),
        ]);

        if ($cart) {
            return response()->json([
                'type' => 'uccess',
                'message' => 'Cart data added successfully',
                'code' => 201,
                'data' => $cart,
            ]);
        } else {
            return response()->json(
                [
                    'type' => 'failure',
                    'message' => 'Cart data not added successfully',
                    'code' => 422,
                ],
                422,
            );
        }
    }
    //Display the specified cart.
    public function show(Request $request, $id)
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
        $cart->update($request->all());
        return response()->json($cart);
    }

    // Remove the specified Category
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
