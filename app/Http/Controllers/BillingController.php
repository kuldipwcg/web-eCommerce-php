<?php

namespace App\Http\Controllers;

use App\Http\Requests\billingRequest;
use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    //list all BillingAddress with their paginate by 10 items per pageto items
    public function index()
    {
        $billings = Billing::paginate(10);
        return response()->json($billings);
    }

  // Store a newly billingAddress :-
    public function store(billingRequest $request)
    {
        $billing = Billing::create($request->all());
        return response()->json($billing, 201);
    }

     // Retrieve the billingAddress by ID
    public function show($id)
    {
        $billing = Billing::find($id);
        if (!$billing) {
            return response()->json(['error' => 'Not found'], 422);
        }
        return response()->json($billing);
    }

    //Method to Update BillingAddress :-
    public function update(BillingRequest $request, $id)
    {
        $billing = Billing::find($id);
        if (!$billing) {
            return response()->json(['error' => 'Not found'], 422);
        }
        $billing->update($request->all());
        return response()->json($billing);
    }

   // Remove the specified Category BillingAddress :-
    public function destroy($id)
    {
        $billing = Billing::find($id);
        if (!$billing) {
            return response()->json(['error' => 'Not found'], 422);
        }
        $billing->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
