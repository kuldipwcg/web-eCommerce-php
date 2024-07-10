<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\ProductVariants;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //list all cart with their  paginate by  10 items per page to items :-
    public function index()
{
    $carts = Cart::where('order_placed', 0)->paginate(10);
    return response()->json($carts);
}

    // public function store(cartRequest $request)
    // {
    //     // dd(request()->all());
    //     $cart = Cart::create($request->all());

    //     return response()->json($cart, 201);
    // }

    public function store(cartRequest $request)
    {
        $cart = Cart::create($request->except('id'));
        return response()->json($cart, 201);
    }
        
    public function show($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        return response()->json($cart);
    }
    public function update(cartRequest $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 200);
        }
        $cart->quantity = $request->quantity;
        $cart->color = $request->color;
        $cart->size = $request->size;
        $cart->variant_id = $request->variant_id;
        $cart->order_placed = $request->order_placed;
        $cart->save();
        return response()->json($cart);
    }

    // Remove the specified Category
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 200);
        }
        $cart->delete();
        return response()->json(['message' => 'Cart deleted successfully']);
    }
}