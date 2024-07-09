<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Models\order_item;
use Illuminate\Http\Request;

class orderItemConteroller extends Controller
{
    public function index()
    {
        $orderItems = order_item::all();
        return response()->json($orderItems);
    }
    public function store(OrderItemRequest $request)
    {
        $orderItem = new order_item();
        $orderItem->order_id = $request->input('order_id');
        $orderItem->product_id = $request->input('product_id');
        $orderItem->quantity = $request->input('quantity');
        $orderItem->unit_price = $request->input('unit_price');
        $orderItem->save();
        return response()->json(['message' => 'Order item created successfully']);
    }
    public function show($id)
    {
        $orderItem = order_item::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Order item not found'], 422);
        }
        return response()->json($orderItem);
    }
    public function update(OrderItemRequest $request, $id)
    {
        $orderItem = order_item::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Order item not found'], 422);
        }
        $orderItem->order_id = $request->input('order_id');
        $orderItem->product_id = $request->input('product_id');
        $orderItem->quantity = $request->input('quantity');
        $orderItem->unit_price = $request->input('unit_price');
        $orderItem->save();

        return response()->json(['message' => 'Order item updated successfully']);
    }
    public function destroy($id)
    {
        $orderItem = order_item::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Order item not found'], 422);
        }
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted successfully']);
    }


}