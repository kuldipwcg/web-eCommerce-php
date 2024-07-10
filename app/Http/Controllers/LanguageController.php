<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;

class LanguageController extends Controller
{
    public function index()
    {
        $language = Language::latest()->paginate(10);
        if ($language) {
            return response()->json([
                'data ' => $language,
                'message' => 'success',
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'status'=> 200,
            ], 200);
        }
    }


    public function store(LanguageRequest $request)
    {
        $data = Language::create($request->all());
        if ($data) {
            return response()->json([
                'data ' => $data,
                'message' => "Data inserted successfully",
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'status'=> 500,
            ], 200);
        }
    }


    public function show($id)
    {
        $data = Language::findOrFail($id);
        if ($data) {
            return response()->json([
                'data' => $data,
                'message' => 'success',
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'status' => 200,
            ], 200);
        }
    }


    public function update(LanguageRequest $request, $id)
    {
        $data = Language::findOrFail($id);
        if ($data) {
            $data->update($request->all());
            return response()->json([
                'data' => $data,
                'message' => "Data updated successfully",
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'status' => 200,
            ], 200);
        }
    }


    public function destroy($id)
    {
        $data = Language::findOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'data' => $data,
                'message' => "Data deleted successfully",
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'data not found',
                'status' => 200,
            ], 200);
        }
    }
}
