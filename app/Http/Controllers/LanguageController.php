<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $data = Language::latest()->paginate(10);
        if ($data) {
            return response()->json([
                'data ' => $data,
                'status' => 'success',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'code'=> 500,
            ], 200);
        }
    }


    public function store(StoreLanguageRequest $request)
    {
        $data = Language::create($request->all());
        if ($data) {
            return response()->json([
                'Message' => "Data inserted successfully",
                'data ' => $data,
                'status' => 'success',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'code'=> 500,
            ], 200);
        }
    }


    public function show($id)
    {
        $data = Language::findOrFail($id);
        if ($data) {
            return response()->json([
                'data' => $data,
                'status' => 'success',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'code' => 500,
            ], 200);
        }
    }


    public function update(UpdateLanguageRequest $request, $id)
    {
        $data = Language::findOrFail($id);
        if ($data) {
            $data->update($request->all());
            return response()->json([
                'Message' => "Data updated successfully",
                'data' => $data,
                'status' => 'success',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'code' => 500,
            ], 200);
        }
    }


    public function destroy($id)
    {
        $data = Language::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'Message' => "Data deleted successfully",
                'data' => $data,
                'status' => 'success',
                'code' => 200,
            ]);
        } else {
            // return response()->json([
            //     'Message' => "Data deleted successfully",
            //     'status' => 'success',
            //     'code'=>200,
            // ]);
            return response()->json([
                'message' => 'data not found',
                'code' => 500,
            ], 200);
        }
    }
}
