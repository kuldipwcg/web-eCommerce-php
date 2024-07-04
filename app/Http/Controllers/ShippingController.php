<?php

namespace App\Http\Controllers;

use App\Http\Requests\shippingRequest;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $shippings = Shipping::paginate(10);

        return response()->json($shippings);
    }

    // public function store(shippingRequest $request)
    // {
    //     $shipping = Shipping::create($request->all());
    //     return response()->json($shipping, 201);
    // }

    public function store(ShippingRequest $request)
    {
        if ($request->input('ship_to_different')) {
            $shipping = Shipping::create($request->all());
        } else {
            $shipping = Shipping::create([
                'order_id' => $request->input('order_id'),
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobileNumber' => $request->input('mobileNumber'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'zipCode' => $request->input('zipCode'),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'shippingCost' => $request->input('shippingCost'),
                'shipping_address1' => $request->input('address1'),
                'shipping_address2' => $request->input('address2'),
                'shipping_zipCode' => $request->input('zipCode'),
                'shipping_country' => $request->input('country'),
                'shipping_state' => $request->input('state'),
                'shipping_city' => $request->input('city'),
            ]);
        }

        return response()->json($shipping, 201);
    }

    // public function show($id)
    // {
    //     $data = Shipping::findOrFail($id);
    //     return response()->json([
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function show($id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($shipping);
    }

    // public function update(Request $request, $id)
    // {
    //     $data = Shipping::findOrFail($id);
    //     $data->update($request->all());
    //     return response()->json([
    //         'Message' => "Data updated successfully",
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function update(ShippingRequest $request, $id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $shipping->update($request->all());
        return response()->json($shipping);
    }

    // public function destroy($id)
    // {
    //     $data = Shipping::findOrFail($id);
    //     $data->delete();
    //     return response()->json([
    //         'Message' => "Data deleted successfully",
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function destroy($id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $shipping->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
