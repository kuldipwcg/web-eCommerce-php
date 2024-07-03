<?php

namespace App\Http\Controllers;

use App\Http\Requests\billingRequest;
use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::paginate(10);
        return response()->json($billings);
    }
    
    // public function store(Request $request)
    // {
    //     $data = Billing::create($request->all());
    //     return response()->json([
    //         'Message' => "Data inserted successfully",
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function store(billingRequest $request)
    {
        $billing = Billing::create($request->all());
        return response()->json($billing, 201);
    }
    // public function show($id)
    // {
    //     $data = Billing::findOrFail($id);
    //     return response()->json([
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function show($id)
    {
        $billing = Billing::find($id);
        if (!$billing) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($billing);
    }


    // public function update(Request $request, $id)
    // {
    //     $data = Billing::findOrFail($id);
    //     $data->update($request->all());
    //     return response()->json([
    //         'Message' => "Data updated successfully",
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function update(BillingRequest $request, $id)
    {
        $billing = Billing::find($id);
        if (!$billing) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $billing->update($request->all());
        return response()->json($billing);
    }


    // public function destroy($id)
    // {
    //     $data = Billing::findOrFail($id);
    //     $data->delete();
    //     return response()->json([
    //         'Message' => "Data deleted successfully",
    //         'data' => $data,
    //         'status' => 200
    //     ]);
    // }
    public function destroy($id)
    {
        $billing = Billing::find($id);
        if (!$billing) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $billing->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
