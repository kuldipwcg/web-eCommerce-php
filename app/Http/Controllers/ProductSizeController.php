<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSizeRequest;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    public function index()
    {
        $size = ProductSize::where('status', 'active')->orderBy('created_at')->get();
        return response()->json(["size"=>$size]);
    }


    public function store(ProductSizeRequest $request)
    {
        $size = ProductSize::create($request->all());
        return response()->json([
            'Message' => "Size inserted successfully.",
            'data' => $size,
            'status' => 200
        ]);
    }

    public function update(ProductSizeRequest $request, $id)
    {
        $size = ProductSize::find($id);
        if(!$size || $size->status !== 'active'){
            return response()->json([
                'Message' => "Size is not available or not active",
                'status' => 200
            ],200);
        }

        $size->update($request->all());
        $size->save();
        return response()->json([
            'Message' => "Size Updated successfully.",
            'data' => $size,
            'status' => 200
        ]);
    }

    public function destroy($id)
    {
        $size = ProductSize::find($id);
        if(!$size){
            return response()->json([
                'Message' => "Size is not available",
                'status' => 200
            ],200);
        }

        $size->delete();
        return response()->json([
            'Message' => "Size Deleted successfully.",
            'status' => 200
        ]);
    }

    public function sizestatus(Request $request, $id)
    {
        $size = ProductSize::find($id);
        if(!$size){
            return response()->json([
                'Message' => "Size is not available",
                'status' => 200
            ],200);
        }

        $size->status = $request->status;
        $size->save();
        return response()->json([
            'message' => 'Size status updated successfully.',
            'status' => 200
        ]);
    }
    
}
