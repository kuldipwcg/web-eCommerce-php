<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;

class OrderController extends Controller
{
    //
    public function index()
    {
        return response()->json(Order::latest()->paginate(10));
    }

    public function store(OrderRequest $request)
    {
        $ORDER = Order::create([
            'user_id' => $request->user_id,
            'cart_id' => $request->cart_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
            'total' => $request->total,
        ]);

        return response()->json(['data' => $ORDER, 'status' => 200]);
    }

    public function show($id)
    {
        $ORDER = Order::find($id);
        if (!$ORDER) {
            return response()->json(['error' => 'Order not found'], 404);
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
            return response()->json(['error' => 'Order not found'], 404);
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
            return response()->json(['error' => 'Order not found'], 404);
        }
        $ORDER->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}