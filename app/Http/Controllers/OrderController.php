<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Billing;
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
        $order = Order::create([
            'user_id'=>$request->user_id,   
            'status'=>$request->status,
            'total'=>$request->total,
            'order_date'=>$request->order_date
        ]);

        // dd($order);
        $carts = Cart::where('user_id', $request->user_id)->get();

        foreach($carts as $cart){
            // dd($cart);
            $product = Product::where('id', $cart->product_id)->get();
            order_item::create([
                'order_id'=>$order->id,
                'product_id'=>$cart->product_id,
                'quantity'=>$cart->quantity,
                'color'=>$cart->color,
                'size'=>$cart->size,
                'unit_price'=>$product->price
            ]);
        }

        $billingaddress = Billing::create([
            'order_id' => $order->id,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'mobileNumber' => $request->mobileNumber,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'zipCode' => $request->zipCode,
            'state' => $request->state,
            'city' => $request->city
        ]);

        $orderItem = order_item::where('order_id', $order->id)->get();
        return response()->json($orderItem);
        // return response()->json(['data' => $ORDER, 'status' => 200]);
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