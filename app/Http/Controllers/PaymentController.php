<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments);
    }
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->all());
        return response()->json($payment, 201);
    }
    public function show(Payment $payment)
    {
        return response()->json($payment);
    }
    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->update($request->all());
        return response()->json($payment);
    }
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(null, 204);
    }

}