<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //list all Payment :-

    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }

    // Store a newly created payment:-
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }

    //Display the specified payment.
    public function show(Payment $payment)
    {
        return response()->json($payment);
    }
   
}
