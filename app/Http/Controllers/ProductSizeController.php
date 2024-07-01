<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSizeRequest;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    public function index()
    {
        return response()->json(ProductSize::orderBy('created_at')->get());
    }


    public function store(ProductSizeRequest $request)
    {
        $record = ProductSize::create($request->all());
        return response()->json([
            'Message'=>"Size inserted successfully",
            'data' => $record, 
            'status' => 200
        ]);
    }


    public function show($id)
    {
        $record = ProductSize::findOrFail($id);
        return response()->json([
            'data' => $record, 
            'status' => 200
        ]);
    }


    public function update(ProductSizeRequest $request, $id)
    {
        $record = ProductSize::findOrFail($id);
        $record->update($request->all());
        return response()->json([
            'Message'=>"Size Updated successfully",
            'data' => $record, 
            'status' => 200
        ]);
    }


    public function destroy($id)
    {
        $record = ProductSize::findOrFail($id);
        $record->delete();
        return response()->json([
            'Message'=>"Size Deleted successfully",
            'status' => 200
        ]);
    }
}
