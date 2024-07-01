<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return response()->json([
            'billingAddresses'=>Billing::latest()->paginate(10),
            'massage' => "success",
            'status' => 200
        ]);
    }


    public function store(Request $request)
    {
        $data = Billing::create($request->all());
        return response()->json([
            'Message' => "Data inserted successfully",
            'data' => $data,
            'status' => 200
        ]);
    }


    public function show($id)
    {
        $data = Billing::findOrFail($id);
        return response()->json([
            'data' => $data,
            'status' => 200
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = Billing::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'Message' => "Data updated successfully",
            'data' => $data,
            'status' => 200
        ]);
    }


    public function destroy($id)
    {
        $data = Billing::findOrFail($id);
        $data->delete();
        return response()->json([
            'Message' => "Data deleted successfully",
            'data' => $data,
            'status' => 200
        ]);
    }
}
