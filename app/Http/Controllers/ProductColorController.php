<?php

namespace App\Http\Controllers;


use App\Models\ProductColor;
use App\Http\Requests\ProductColorRequest;
use Illuminate\Http\Request;


class ProductColorController extends Controller
{
    public function index()
    {
        $color = ProductColor::orderBy('created_at')->get();
        return response()->json(["color"=>$color]);
        $color = ProductColor::orderBy('created_at')->get();
        return response()->json(["color"=>$color]);
    }

    public function store(ProductColorRequest $request)
    {
        $color = ProductColor::create($request->all());
        
        
        return response()->json([
            'data' => $color,
            'message' => "Data inserted successfully",
            'message' => "Data inserted successfully",
            'status' => 200
        ],200);
        ],200);
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

        $color = ProductColor::find($id);
        if(!$color  || $color->status !== 'active'){
            return response()->json([
                'Message' => "Color is not available or not active",
                'status' => 404
            ],404);
        }

        $color->update($request->all());
        $color->save();
        $color->save();
        return response()->json([
            'Message' => "Size Updated successfully.",
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
                'message' => "Data deleted successfully",
                'status' => 200
            ],200);
        }else {
            return response()->json([
                'message' => "Data not found",
                'status' => 404
            ],404);
        }
    }
    public function colorstatus(Request $request, $id)
    {
        $color = ProductColor::find($id);
        if(!$color){
            return response()->json([
                'Message' => "Color is not available",
                'status' => 404
            ],404);
        }
        $color->status = $request->status;
        $color->save();

        return response()->json(['message' => 'ProductColor status updated successfully']);
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
                'status' => 404
            ],404);
        }
    }
    public function colorstatus(Request $request, $id)
    {
        $color = ProductColor::find($id);
        if(!$color){
            return response()->json([
                'Message' => "Color is not available",
                'status' => 404
            ],404);
        }
        $color->status = $request->status;
        $color->save();

        return response()->json(['message' => 'ProductColor status updated successfully']);
    }
}
