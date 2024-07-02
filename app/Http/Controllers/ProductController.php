<?php

namespace App\Http\Controllers;


use App\Models\PivotColor;
use App\Models\PivotSize;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductVariants;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(){
        
        $product = Product::with(['product_colors','product_sizes','product_image','product_variants'])->get();
        return response()->json([
            'Product'=>$product
        ]);
    }
    
    public function store(Request $request){
        $p = Product::create([
            'product_name' => $request->product_name,
            'short_desc'=>$request->short_desc,
            'description' => $request->description,
            'information' => $request->information,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'discount_type'=>$request->discount_type,
            'discount_value' => $request->discount_value,
            
        ]);

        // if($request->has('colors')){
        //     foreach($request->colors as $color){
        //         $p->product_colors()->attach($color);
        //     }              
        // }
        
        // if ($request->has('sizes')) {
        //     foreach ($request->sizes as $size) {
        //         $p->product_sizes()->attach($size);
        //     }
        // }

        foreach($request->variants as $v){
            // dd($v['color_id']);
            // $p->product_colors()->attach($v['color_id']);
            PivotColor::create([
                'product_id'=>$p->id,
                'color_id'=>$v['color_id'],
            ]);
            PivotSize::create([
                'product_id'=>$p->id,
                'size_id'=>$v['size_id'],
            ]);
            // $p->product_sizes()->attach($v['size_id']);
            ProductVariants::create([
                'product_id' => $p->id,
                'color_id' => $v['color_id'],
                'size_id' => $v['size_id'],
                'quantity' => $v['quantity'],
            ]);
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
        return response()->json([$p->load(['product_colors','product_sizes','product_variants','product_image'])],200);
    }

}
