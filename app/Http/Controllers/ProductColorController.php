<?php

namespace App\Http\Controllers;


use App\Models\ProductColor;
use App\Http\Requests\ProductColorRequest;

class ProductColorController extends Controller
{
    public function index()
    {
        return response()->json(ProductColor::orderBy('color','DESC')->paginate(10));
    }


    public function store(ProductColorRequest $request)
    {
        // dd($request->all());
        $record = ProductColor::create($request->all());
        return response()->json(['data' => $record, 'status' => 200]);
    }


    public function show($id)
    {
        $color = ProductColor::findOrFail($id);
        return response()->json($color, 200);
    }


    public function update(ProductColorRequest $request, $id)
    {
        $color = ProductColor::findOrFail($id);
        $color->update($request->all());
        return response()->json($color, 200);
    }


    public function destroy($id)
    {
        $color = ProductColor::findOrFail($id);
        $color->delete();
        return response()->json(null, 200);
    }
}
