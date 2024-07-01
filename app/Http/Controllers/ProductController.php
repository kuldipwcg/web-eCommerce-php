<?php

namespace App\Http\Controllers;


use App\Models\PivotColor;
use App\Models\PivotSize;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(){
        $product = Product::with(['product_colors', 'product_sizes', 'reviews', 'product_image'])->get();
        return response()->json([
            'Product'=>$product
        ]);
    }
    
    public function store(Request $request){
        $p = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'product_price' => $request->product_price,
            'information' => $request->information,
            'category_id' => $request->category_id,
            'discount_id' => $request->discount_id,
            'is_featured' => $request->is_featured
        ]);

        if($request->has('colors')){
            foreach($request->colors as $color){
                $p->product_colors()->attach($color);
            }              
        }
        
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                $p->product_sizes()->attach($size);
            }
        }
        
        if($request->has('image')){
            foreach($request->file('image') as $image){
                $imagename =$image->getClientOriginalName();  
                $image->move(public_path('/upload/productimg/'), $imagename); 

                $productimg = url('/upload/productimg/' . $imagename);
                ProductImage::create([
                    'product_id' => $p->id,
                    'product_image' => $productimg,
                ]);
            }
        }
        return response()->json([$p->load(['product_colors', 'product_sizes', 'reviews', 'product_image'])],200);
    }

}
