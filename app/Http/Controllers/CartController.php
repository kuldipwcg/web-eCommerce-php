<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return response()->json(Cart::all());
    }

    public function store(cartRequest $request)
     {
    
        // $image = $request->file('image');
        // $imageName = $image->getClientOriginalName();
        // $image->move(public_path('/upload/cart/'), $imageName);
        // $cartUrl = url('/upload/cart/' . $imageName);

        $cart = Cart::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'total' => $request->input('total'),
            'order_placed' => $request->input('order_placed', false),
            'variants_id' =>$request->input('variants_id'),
            // 'image' => $cartUrl,
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
            return response()->json(['error' => 'Cart not found'], 404);
        }
        $cart->update($request->all());
        return response()->json($cart);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        $cart->delete();
        return response()->json(['message' => 'Cart item deleted successfully']);
    }
}
