<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::with(['orderItems', 'billings'])->latest()->paginate(10);
        return response()->json([
            'data' => $orders,
            'status' => 200,
        ], 200);
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $orderItems = [];
        $order = Order::create([
            'user_id' => $userId,
            'total' => $request->total,
        ]);
        $billingaddress = $request->input('billingaddress');
        if ($billingaddress) {
            Billing::updateOrCreate(['order_id' => $order->id,], $billingaddress);
        } else {
            return response()->json([
                'message' => 'Billing Address is not avaliable',
                'status' => 200,
            ], 200);
        }

        $shippingaddress = $request->input('shippingaddress');
        if ($shippingaddress) {
            Shipping::updateOrCreate(['order_id' => $order->id,], $shippingaddress);
        } else {
            Shipping::updateOrCreate(['order_id' => $order->id,], $billingaddress);
        }

        $carts = Cart::where('user_id', $userId)->where('order_placed', false)->get();
        if ($carts->isEmpty()) {
            return response()->json([
                'message' => 'your cart is empty',
                'status' => 200,
            ], 200);
        } else {
            foreach ($carts as $cart) {
                $product = Product::find($cart->product_id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'color' => $cart->color,
                    'size' => $cart->size,
                    'unit_price' => $product->price
                ]);
            }
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        $data = [];
        foreach($orderItems as $item)
        {

            $data[] = [
                'Name' => Product::where('id', $item->product_id)->first()->product_name,
                'Price' => "".$item->unit_price * $item->quantity,
                'Color' => $item->color,
                'Size' => $item->size,
                'Quantity' => "".$item->quantity,
            ];

        }

         $total = Order::where('id', $order->id)->first()->total;

        $userEmail = auth()->user()->email;
        
        Mail::to($userEmail)->send(new OrderMail([
            'item' => $data,
            'total'=> $total,
         ]));

        return response()->json([
            'message' => 'Order place successfully',
            'status' => 200,
        ], 200);
    }

    public function show($id)
    {
        $userId = auth()->user()->id;

        $orders = Order::wher('user_id', $userId)->with(['orderItems', 'billings', 'shippings'])->latest()->paginate(10);
        return response()->json([
            'data' => $orders,
            'status' => 200,
        ], 200);
    }
}
