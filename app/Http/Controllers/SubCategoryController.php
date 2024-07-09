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
            $subCategories=subCategory::with('Category')->latest()->paginate(10);
            return response()->json([
                
                'type'=>'success',
                'message'=>'subCategories showed successfully',
                'code'=>200,
                'data'=>$subCategories
            ]);
        }



    public function store(SubCategoryRequest $request){
        
        $data = [   
            'categoryId' => $request->categoryId,
            'subcategoryName' =>$request->subcategoryName  
        ];
        $subCategory = DB::table('sub_categories')->insert($data);
            return response()->json([
                'type'=>'success',
                'message'=>'subCategory added successfully',
                'code'=>200,
                'data'=>$subCategory
            ]);
            

    }
      
    public function show($id)    
    {
        $subCategory = Subcategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'subCategory Not found'], 404);
        }
        return response()->json([
            'type'=>'success',
            'message'=>'Particular subCategory showed successfully',
            'code'=>200,
            'data'=>$subCategory
        ]);
    }

    public function update(SubCategoryRequest $request, $id)
    {

        $subCategory = Subcategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'subCategory not found'], 404);
        }
        $data = [   
            'categoryId' => $request->categoryId,
            'subcategoryName' =>$request->subcategoryName  
        ];
        $subCategory = DB::table('sub_categories')->update($data);
        return response()->json([
            'type'=>'success',
            'message'=>'subCategory updated successfully',
            'code'=>200,
            'data'=>$subCategory
        ]);
    }

    public function destroy($id){
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['error' => 'subCategory not found'], 404);
        }

        $subCategory->delete();

        return response()->json([
            'type'=>'success',
            'message'=>'subCategory deleted successfully',
            'code'=>200,
            'data'=>$subCategory
        ]);
    }
}
