<?php

namespace App\Http\Controllers;


use App\Models\ProductColor;
use App\Http\Requests\ProductColorRequest;
use Illuminate\Support\Facades\Request;

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
        $color = ProductColor::find($id);
        if(!$color  || $color->status !== 'active'){
            return response()->json([
                'Message' => "Color is not available or not active",
                'status' => 404
            ],404);
        }

        $color->update($request->all());
        $color->save();
        return response()->json([
            'Message' => "Size Updated successfully.",
            'data' => $color,
            'status' => 200
        ]);

    }

    public function destroy($id)
    {
        $color = ProductColor::find($id);
        if ($color) {
            $color->delete();
            return response()->json([
                'data' => $color,
                'message' => "Color deleted successfully",
                'status' => 200
            ],200);
        }else {
            return response()->json([
                'message' => "Color not found",
                'status' => 200
            ],200);
        }
    }
    public function colorStatus(Request $request, $id)
    {
        $color = ProductColor::find($id);
        $color->status = $request->status;
        $color->save();
        return response()->json(['message' => 'ProductColor status updated successfully'],200);
    }
}