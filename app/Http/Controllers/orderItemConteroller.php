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
}
