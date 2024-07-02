<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        return response()->json([
            'shippingAddresses'=>Shipping::latest()->paginate(10),
            'massage' => "success",
            'status' => 200
        ]);
    }


    public function store(Request $request)
    {
        $data = Shipping::create($request->all());
        return response()->json([
            'Message' => "Data inserted successfully",
            'data' => $data,
            'status' => 200
        ]);
    }


    public function show($id)
    {
        $data = Shipping::findOrFail($id);
        return response()->json([
            'data' => $data,
            'status' => 200
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = Shipping::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'Message' => "Data updated successfully",
            'data' => $data,
            'status' => 200
        ]);
    }


    public function destroy($id)
    {
        $data = Shipping::findOrFail($id);
        $data->delete();
        return response()->json([
            'Message' => "Data deleted successfully",
            'data' => $data,
            'status' => 200
        ]);
    }
}
