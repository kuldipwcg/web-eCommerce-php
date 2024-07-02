<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();
        return response()->json($carts);
    }

    public function store(cartRequest $request)
    {
        $cart = Cart::create($request->all());
        return response()->json($cart, 201);
    }

    public function show(Cart $cart)
    {
        return response()->json($cart);
    }

    public function update(CartRequest $request, Cart $cart)
    {
        $cart->update($request->all());
        return response()->json($cart);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(null, 204);
    }
}
