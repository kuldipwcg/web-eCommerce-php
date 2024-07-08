<?php

namespace App\Http\Controllers;

<<<<<<< Updated upstream
use App\Http\Requests\CategoryRequest;
=======
>>>>>>> Stashed changes
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\categoryValidation;

class CategoryController extends Controller
{
<<<<<<< Updated upstream
    public function index()
    {
        // $category=Category::with('subcategories')->get();
        // // dd($category);
        // return response()->json(Category::all());
        $category = Category::with('subcategories')->latest()->paginate(10);

        return response()->json([
            'type' => 'success',
            'message' => 'Category showed successfully',
            'code' => 200,
            'data' => $category,
        ]);
    }

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
        return response()->json(['message' => 'category added successfully', 'data' => $record, 'status' => 200]);
    }
    public function show()
    {
        $category = Category::get();
=======
    
    public function index()
    {
        return response()->json(Category::all());
    }

    public function store(categoryValidation $request){
        // dd($request->all());
        $category = Category::create($request->all());
            return response()->json($category, 201);
                
    }
    public function show($id)	
    {
        $category = Category::find($id);
>>>>>>> Stashed changes
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

<<<<<<< Updated upstream
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $image = $request->file('image');
        $imageName = time() . $image->getClientOriginalName();
        $image->move(public_path('/upload/images/'), $imageName);

        $category->update([
            'category_name' => $request->category_name,
            'sub_categories_id' => $request->sub_categories_id,
            'image' => $imageName,
            'status' => $request->status,
        ]);
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
=======
    public function update(categoryValidation $request, $id)
    {
        $category = Category::findOrFail($id);
        // dd($id);
        if (!$category) {
           
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id){
>>>>>>> Stashed changes
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
