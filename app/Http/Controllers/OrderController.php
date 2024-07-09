<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\order_item;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;

class OrderController extends Controller
{
    //
    public function index()
    {
        return response()->json(Order::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $order = Order::create([
            'user_id' => $userId,
            'total' => $request->total,
        ]);

        $carts = Cart::where('user_id', $request->user_id)->get();
        foreach ($carts as $cart) {

            $product = Product::where('id', $cart->product_id)->get();

            order_item::create([
                'order_id'=>$order->id,
                'product_id'=>$cart->product_id,
                'color'=>$cart->color,
                'size'=>$cart->size,
                'variants_id'=>$cart->variants_id,
                'quantity'=>$cart->quantity,
                'unit_price'=>$product->price,
            ]);
        }


    }
    public function show($id)
    {
        $ORDER = Order::find($id);
        if (!$ORDER) {
            return response()->json(['error' => 'Order not found'], 422);
        }

        return response()->json(
            [
                'code' => 200,
                'data' => $ORDER,
            ],
            200,
        );
    }

    public function update(OrderRequest $request, $id)
    {
        $ORDER = Order::find($id);
        if (!$ORDER) {
            return response()->json(['error' => 'Order not found'], 422);
        }

        $ORDER->update([
            'user_id' => $request->user_id,
            'cart_id' => $request->cart_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
            'total' => $request->total,
        ]);

        return response()->json($ORDER);
    }

    public function destroy($id)
    {
        $ORDER = Order::find($id);
        if (!$ORDER) {
            return response()->json(['error' => 'Order not found'], 422);
        }
        $ORDER->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
