<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    public function index()
    {
        return response()->json(Cart::all());
        return response()->json(Cart::all());
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
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        return response()->json($cart);
    }
    public function update(cartRequest $request, $id)
    public function update(cartRequest $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $cart->update($request->all());
        return response()->json($cart);
    }

    public function destroy($id)
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        $cart->delete();
        $cart->delete();
        return response()->json(['message' => 'Cart item deleted successfully']);
    }
}
