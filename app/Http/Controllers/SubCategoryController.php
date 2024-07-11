<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //list all subcategory with paginate by  10 items per pageto items :-
    public function index()
    {
        $subCategory = subCategory::with('Category')->latest()->paginate(10);
        return response()->json([
            'type' => 'success',
            'message' => 'Category showed successfully',
            'status' => 200,
            'data' => $subCategory,
        ],200);
    }

    // Store a newly created subCategory
    public function store(Request $request)
    {
        $subCategory = Subcategory::create($request->all());

        return response()->json(['data' => $subCategory], 201);
    }

    // Retrieve the subcategory by ID
    public function show()
    {
        $subCategory = Subcategory::get();
        if (!$subCategory) {
            return response()->json(['error' => 'No SubCategory not found'], 200);
        }
        return response()->json($subCategory);
    }

    //method to update subCategory
    public function update(SubCategoryRequest $request, $id)
    {
        $subCategory = Subcategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'SubCategory not found'], 200);
        }
        $subCategory->update($request->all());
        return response()->json($subCategory);
    }

    // Remove the specified subCategory
    public function destroy($id)
    {
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'SubCategory not found'], 200);
        }
        $subCategory->delete();
        return response()->json(['message' => 'SubCategory deleted successfully'],200);
    }
}