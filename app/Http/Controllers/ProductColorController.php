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
<<<<<<< HEAD
        return response()->json([
            'Message' => 'Data inserted successfully',
            'data' => $color,
            'status' => 200,
        ]);
    }

    public function show($id)
    {
        $color = ProductColor::findOrFail($id);
        return response()->json([
            'data' => $color,
            'status' => 200,
        ]);
    }

    public function update(ProductColorRequest $request, $id)
    {
        $color = ProductColor::find($id);

        if (!$color || $color->status !== 'active') {
            return response()->json(
                [
                    'message' => 'color is not available or not active',
                    'status' => 200,
                ],
                200,
            );
        }
        $color->update($request->all());

        return response()->json([
            'Message' => 'Color Updated successfully.',
=======
        return response()->json([
            'Message' => "Data inserted successfully",
>>>>>>> bd3fcfe (update in controller)
            'data' => $color,
            'status' => 200,
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
        $color = ProductColor::find($id);
        if ($color) {
            $color->delete();
<<<<<<< HEAD
            return response()->json(
                [
                    'data' => $color,
                    'message' => 'Color deleted successfully',
                    'status' => 200,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'message' => 'Color not found',
                    'status' => 200,
                ],
                200,
            );
=======
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
>>>>>>> bd3fcfe (update in controller)
        }
    }
    public function colorStatus(Request $request, $id)
    {
        $color = ProductColor::find($id);
<<<<<<< HEAD
        $color->status = $request->status;
        $color->save();
        return response()->json(['message' => 'ProductColor status updated successfully'], 200);
=======
        if(!$color){
            return response()->json([
                'Message' => "Color is not available",
                'status' => 200
            ],200);
        }
        $color->status = $request->status;
        $color->save();

        return response()->json(['message' => 'ProductColor status updated successfully']);
>>>>>>> bd3fcfe (update in controller)
    }
}