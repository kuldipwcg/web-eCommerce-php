<?php

namespace App\Http\Controllers;


use App\Models\ProductColor;
use App\Http\Requests\ProductColorRequest;

class ProductColorController extends Controller
{
    public function index()
    {
        return response()->json(ProductColor::latest()->paginate(10));
    }


    public function store(ProductColorRequest $request)
    {
        $color = ProductColor::create($request->all());
        return response()->json([
            'Message' => "Data inserted successfully",
            'data' => $color,
            'status' => 200
        ]);
    }


    public function show($id)
    {
        $color = ProductColor::findOrFail($id);
        return response()->json([
            'data' => $color,
            'status' => 200
        ]);
    }


    public function update(ProductColorRequest $request, $id)
    {
        $color = ProductColor::findOrFail($id);
        $color->update($request->all());
        return response()->json([
            'Message' => "Data updated successfully",
            'data' => $color,
            'status' => 200
        ]);
    }


    public function destroy($id)
    {
        $color = ProductColor::findOrFail($id);
        $color->delete();
        return response()->json([
            'Message' => "Data deleted successfully",
            'data' => $color,
            'status' => 200
        ]);
    }
}
