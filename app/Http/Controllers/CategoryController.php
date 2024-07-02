<?php





namespace App\Http\Controllers;


use App\Http\Requests\CategoryRequest;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    public function index()
    {
        // $category=Category::with('subcategories')->get();
        // // dd($category);
        // return response()->json(Category::all());
        $category=Category::with('subcategories')->latest()->paginate(10);
        //dd($sub_category);
        return response()->json($category);
    }

    public function store(CategoryRequest $request)
    {

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();

        $image->move(public_path('/upload/images/'), $imageName);

        $record = Category::create([
            'category_name' => $request->category_name,
            'sub_categories_id' => $request->sub_categories_id,
            'image' => $imageName,
            'status' => $request->status,
        ]);
        return response()->json(['data' => $record, 'status' => 200]);

    }
    public function show($id)    
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($category);
    }
<<<<<<< HEAD
<<<<<<< HEAD


=======
    
>>>>>>> 7363e18 (category,sub-category and cart api)
=======
    
>>>>>>> 7363e18 (category,sub-category and cart api)
    public function update(CategoryRequest $request, $id)
    {

        $category = Category::findOrFail($id);

        $image = $request->file('image');

     

        $imageName = time() . $image->getClientOriginalName();
        $image->move(public_path('/upload/images/'), $imageName);

        $category ->update([
            'category_name' => $request->category_name,
            'sub_categories_id' => $request->sub_categories_id,
            'image' => $imageName,
            'status' => $request->status,
            
        ]);
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
