<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\categoryValidation;

class CategoryController extends Controller
{
    //list all category with their Subcagory paginate by  10 items per pageto items :-
    public function index()
    {

        $category = Category::with('subcategories')->latest()->paginate(10);


        return response()->json([
            'data' => $category,
            'type' => 'success',
            'message' => 'Category showed successfully',
            'status' => 200,
        ]);
    }

    // Store a newly created Category
    public function store(CategoryRequest $request)
    {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('/upload/category/'), $imageName);
        $categoryUrl = url('/upload/category/' . $imageName);
        $record = Category::create([
            'category_name' => $request->category_name,
            'image' => $categoryUrl,
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'Category added successfully', 'data' => $record, 'status' => 200]);
    }

    // Retrieve the category by ID
    public function show($id)

    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 200);
        }
        return response()->json($category);
    }

    //method to update Category
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category || $category->status !== 'active') {
            return response()->json(
                [
                    'Message' => 'Category is not active or not available.',
                    'status' => 422,
                ],
                422,
            );
        }
        
        $image = $request->file('image');
        $imageName = time() . $image->getClientOriginalName();
        $image->move(public_path('/upload/images/'), $imageName);
        $categoryUrl = url('/upload/category/' . $imageName);

        $category->update([
            'category_name' => $request->category_name,
            'sub_categories_id' => $request->sub_categories_id,
            'image' => $categoryUrl,
            'status' => $request->status,
        ]);
        return response()->json($category, 200);
    }

    // Remove the specified Category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 200);
        }
        
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    
}
