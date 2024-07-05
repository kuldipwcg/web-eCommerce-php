<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    // public function index()
    // {
    //     return response()->json(Cart::paginate(10));
    // }
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())->get();
        return response()->json($carts);
    } 
    public function store(Request $request)
    {
        $cart = new Cart();
        $cart->user_id = auth()->id();
        $cart->product_id = $request->input('product_id');
        $cart->quantity = $request->input('quantity');
        $cart->save();
        return response()->json($cart);
    }

    // public function store(Request $request)
    // {
    //     $user = auth()->user();
    //     $product = Product::find($request->all('product_id'));
    //     // if (!$product) {
    //     //     return response()->json(['error' => 'Product not found'], 404);
    //     // }
    //     $cart = Cart::where('user_id', $user->id)
    //         ->where('product_id', $product->id)
    //         ->first();
    //     if ($cart) {
    //         $cart->quantity = min($cart->quantity + 1, 2);
    //         $cart->save(); 
    //     } else {
    //         $cart = new Cart();
    //         $cart->user_id = $user->id;
    //         $cart->product_id = $product->id;
    //         $cart->quantity = 1;
    //         $cart->save();
    //     }
    //     return response()->json(['message' => 'Product added to cart'], 201);
    // }

    public function show($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }
        return response()->json($cart);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $cart->quantity = $request->input('quantity');
        $cart->save();
        return response()->json($cart);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $cart->delete();
        return response()->json(['message' => 'Cart deleted successfully']);
    }
}
