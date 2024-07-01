<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json($this->model::all());
    }

    public function store(Request $request)
    {
        $category = $this->model::create($request->all());
        return response()->json($category, 201);
    }
    public function show($id)
    {
        $category = $this->model::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
        $category = $this->model::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = $this->model::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
