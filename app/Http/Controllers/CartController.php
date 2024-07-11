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

    // Store a newly created cart 
    public function store(Request $request)
    {
        $id = auth()->user()->id;
        $productId = ProductVariants::where('id', $request->variants_id)->pluck('product_id')->first();
        $item = Cart::where('product_id', $productId)->where('user_id', $id)->first();

        if ($item) {
            $newQuantity = $item->quantity + $request->quantity;

            if ($newQuantity <= 0) {
                $item->delete();
                return response()->json(['message' => 'Item removed from cart'],200);
            } else {
                $item->quantity = $newQuantity;
                $item->save();
                return response()->json($item);
            }
        } else {
            if ($request->quantity > 0) {
                $cart = new Cart();
                $cart->quantity = $request->quantity;
                $cart->user_id = $id;
                $cart->product_id = $productId;
                $cart->color = $request->color;
                $cart->size = $request->size;
                $cart->variants_id = $request->variants_id;
                $cart->order_placed = $request->order_placed;
                $cart->save();
                return response()->json($cart);
            } else {
                return response()->json(['error' => 'Invalid quantity'], 200);
            }
        }
    }

    //method to update Cart
    public function update(Request $request, $id)
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