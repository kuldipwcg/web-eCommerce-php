<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubCategoryController extends Controller
{
    
    public function index()
    {
        return response()->json(Subcategory::all());
    }

    public function store(SubCategoryRequest $request){
        
        $sub_category = Subcategory::create($request->all());
        
        return response()->json($sub_category, 201);
    }
    public function show($id)    
    {
        $sub_category = Subcategory::find($id);
        if (!$sub_category) {
            return response()->json(['error' => 'Sub_Category not found'], 404);
        }
        return response()->json($sub_category);
    }

    public function update(SubCategoryRequest $request, $id)
    {

        $sub_category = Subcategory::find($id);
        if (!$sub_category) {
            return response()->json(['error' => 'Sub_Category not found'], 404);
        }
        $sub_category->update($request->all());
        return response()->json($sub_category);
    }

    public function destroy($id){
        $sub_category = Subcategory::find($id);
        if (!$sub_category) {
            return response()->json(['error' => 'Sub_Category not found'], 404);
        }
        $sub_category->delete();
        return response()->json(['message' => 'Sub_Category deleted successfully']);
    }

}
