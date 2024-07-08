<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Illuminate\Http\Request;

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
        
            $subCategories = Subcategory::create($request->all());
            return response()->json([
                'type'=>'success',
                'message'=>'subCategory Added successfully',
                'code'=>200,
                'data'=>$subCategories
            ]);
            

    }
    public function show($id)    
    {
        $subCategories = Subcategory::find($id);
        if (!$subCategories) {
            return response()->json(['error' => 'subCategory Not found'], 404);
        }
        return response()->json([
            'type'=>'success',
            'message'=>'Particular subCategory showed successfully',
            'code'=>200,
            'data'=>$subCategories
        ]);
    }

    public function update(SubCategoryRequest $request, $id)
    {

        $subCategories = Subcategory::find($id);
        if (!$subCategories) {
            return response()->json(['error' => 'subCategory not found'], 404);
        }
        $subCategories->update($request->all());

        return response()->json([
            'type'=>'success',
            'message'=>'subCategory Updated successfully',
            'code'=>200,
            'data'=>$subCategories
        ]);
    }

    public function destroy($id){
        $subCategories = SubCategory::find($id);
        if (!$subCategories) {
            return response()->json(['error' => 'subCategory not found'], 404);
        }

        $subCategories->delete();

        return response()->json([
            'type'=>'success',
            'message'=>'subCategory Deleted successfully',
            'code'=>200,
            'data'=>$subCategories
        ]);
    }
}
