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
            'data' => $color,
            'message' => "Data inserted successfully",
            'status' => 200
        ],200);
    }

    public function update(ProductColorRequest $request, $id)
    {
        $color = ProductColor::find($id);
        if ($color) {
            $color->update($request->all());
            return response()->json([
                'data' => $color,
                'message' => "Data updated successfully",
                'status' => 200
            ],200);
        } else {
            return response()->json([
                'message' => "Data not found",
                'status' => 200
            ],200);
        }
    }

    public function destroy($id)
    {
        $color = ProductColor::find($id);
        if ($color) {
            $color->delete();
            return response()->json([
                'data' => $color,
                'message' => "Data deleted successfully",
                'status' => 200
            ],200);
        }else {
            return response()->json([
                'message' => "Data not found",
                'status' => 200
            ],200);
        }
    }
}
