<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Order;
use App\Models\order_item;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\Else_;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::with(['orderItems','billings','shippings'])->get();
        return response()->json(["order"=>$order,"status"=>200],200);
    }

    public function store(OrderRequest $request)
    {
        $userId = auth()->user()->id;
        $carts = Cart::where('user_id', $userId)->where('order_placed', false)->get();

        if ($carts->isEmpty()) {
            return response()->json(['Message' => 'Cart is Empty'], 200);
        }

        $order = Order::create([
            'user_id' => $userId,
            'total' => $request->total,
            'order_date' => Carbon::now()
        ]);

        $billingAddress = $request->input('billingAddress');
        if ($billingAddress) {
            Billing::updateOrCreate(['order_id' => $order->id], $billingAddress);
        } else {
            return response()->json(["Message" => "Billing address is not available"], 200);
        }

        $shippingAddress = $request->input('shippingAddress');
        if ($shippingAddress) {
            
            Shipping::updateOrCreate(['order_id' => $order->id], $shippingAddress);
        } else {
            Shipping::updateOrCreate(['order_id' => $order->id], $billingAddress);
        }

        foreach ($carts as $cart) {
            $product = Product::where('id', $cart->product_id)->first();
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'color' => $cart->color,
                'size' => $cart->size,
                'unit_price' => $product->price
            ]);
            $productVariant = ProductVariants::find($cart->variants_id);
            if($productVariant){
                $productVariant->decrement('quantity', $cart->quantity);
            }
        }

        Cart::where('user_id', $userId)->update(['order_placed' => true]);

        return response()->json(['Message' => "Order Place Successfully.", "status" => 200], 200);
    }

    public function orderShow()
    {
        $userId = auth()->user()->id;
        $order = Order::with(['orderItems','billings','shippings'])->where('user_id',$userId)->get();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 200);
        }

        return response()->json(['status' => 200,'order' => $order],200);
    }

}