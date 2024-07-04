<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PivotColor;
use App\Models\PivotSize;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['product_image', 'product_variants'])->get();

        $formattedProducts = $products->map(function ($product) {
            $colorsId = $product->product_variants->pluck('color_id')->unique()->values()->all();
            $sizesId = $product->product_variants->pluck('size_id')->unique()->values()->all();
            
            $colors = ProductColor::whereIn('id', $colorsId)->pluck('color');
            $sizes = ProductSize::whereIn('id', $sizesId)->pluck('size');
            // dd($colors);

            return [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'short_desc' => $product->short_desc,
                'description' => $product->description,
                'information' => $product->information,
                'price' => $product->price,
                'discount_type' => $product->discount_type,
                'discount_value' => $product->discount_value,
                'is_featured' => $product->is_featured,
                'colors' => $colors,
                'sizes' => $sizes,
                'product_images' => $product->product_image->pluck('product_image'),
                'product_variants' => $product->product_variants->map(function ($variant) {
                    return [
                        'color' => $variant->color_id,
                        'size' => $variant->size_id,
                        'quantity' => $variant->quantity,
                    ];
                }),
            ];
        });

        return response()->json(['products' => $formattedProducts], 200);
    }

    public function store(Request $request)
    {
        $category = Category::where('category_name', $request->category_name)->first();
        // dd($catid);
        if (!$category) {
            return response()->json([
                'Message' => "Wrong Category",
                "Status" => 404,
            ], 404);
        } else {

            $p = Product::create([
                'product_name' => $request->product_name,
                'short_desc' => $request->short_desc,
                'description' => $request->description,
                'information' => $request->information,
                'price' => $request->price,
                'category_id' => $category->id,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,

            ]);
        }

        foreach ($request->variants as $v) {
            $color = ProductColor::where('color', $v['color'])->first();
            $size = ProductSize::where('size', $v['size'])->first();

            if (!$color) {
                return response()->json([
                    'Message' => "Wrong Colors",
                    "Status" => 404,
                ], 404);
            }
            if (!$size) {
                return response()->json([
                    'Message' => "Wrong Sizes",
                    "Status" => 404,
                ], 404);
            }
            ProductVariants::create([
                'product_id' => $p->id,
                'color_id' => $color->id,
                'size_id' => $size->id,
                'quantity' => $v['quantity'],
            ]);
        }

        if ($request->has('image')) {
            foreach ($request->file('image') as $image) {
                $imagename = $image->getClientOriginalName();
                $image->move(public_path('/upload/productimg/'), $imagename);

                $productimg = url('/upload/productimg/' . $imagename);
                ProductImage::create([
                    'product_id' => $p->id,
                    'product_image' => $productimg,
                ]);
            }
        } else {
            return response()->json([
                'Message' => "Image Not found",
                "Status" => 404,
            ], 404);
        }

        return response()->json([$p->load(['product_variants', 'product_image'])], 200);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        // dd($product);
        if (!$product) {
            return response()->json([
                'Message' => "Product Not found",
                "Status" => 404,
            ], 404);
        }

        $product->product_variants()->delete();
        $product->product_image()->delete();
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        // dd($product);
        if (!$product) {
            return response()->json([
                'Message' => "Product Not found",
                "Status" => 404,
            ], 404);
        }

        $category = Category::where('category_name', $request->category_name)->first();
        // dd($catid);
        if (!$category) {
            return response()->json([
                'Message' => "Wrong Category",
                "Status" => 404,
            ], 404);
        }

        $product->update([
            'product_name' => $request->product_name,
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'information' => $request->information,
            'price' => $request->price,
            'category_id' => $category->id,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'is_featured' => $request->has('is_featured') ? $request->is_featured : 'false',
        ]);
        
        foreach ($request->variants as $key => $value) {

            
            // dd($value['color']);
            $color = ProductColor::where('color',$value['color'])->first();
            $size = ProductSize::where('size',$value['size'])->first();

            // dd($color->id);
            $variation = ProductVariants::where('color_id', $color->id)->where('size_id', $size->id)->where('product_id',$product->id)->first();

            // $novariation = ProductVariants::whereNot('color_id', $color->id)->whereNot('size_id', $size->id)->where('product_id',$product->id)->first();

            // dd($variation);

            $v = ProductVariants::all('id');
            dd($v);

            if ($variation){
                $p = ProductVariants::find($variation->id);
                $variation->update([
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $value['quantity'],
                ]);
                dd($p->id);
            }
            else{
                ProductVariants::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $value['quantity'],
                ]);
                dd('no');
            }
            // $p = ProductVariants::where('product_id', $product->id)
            //     ->whereNotIn('id', $variation->id)->get();
            // // ->delete();
            // dd($p);
            
        }

        

        // $variantIdsToKeep = collect($request->variants)->pluck('id');
        // dd($variantIdsToKeep);
        // ProductVariants::where('product_id', $product->id)
        //     ->whereNotIn('id', $variantIdsToKeep)
        //     ->delete();

        foreach ($request->variants as $v) {
            $color = ProductColor::where('color', $v['color'])->first();
            $size = ProductSize::where('size', $v['size'])->first();
            // dd($color->id);
            if (isset($v['id'])) {
                $variant = ProductVariants::findOrFail($v['id']);
                $variant->update([
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $v['quantity'],
                ]);
            } else {
                ProductVariants::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $v['quantity'],
                ]);
            }
        }
        if ($request->has('image')) {
            foreach ($request->file('image') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('/upload/productimg/'), $imageName);
                $productImgUrl = url('/upload/productimg/' . $imageName);
                $existingImage = ProductImage::where('product_id', $product->id)->first();
                if ($existingImage) {
                    $existingImage->update(['product_image' => $productImgUrl]);
                } else {
                    ProductImage::create(['product_id' => $product->id, 'product_image' => $productImgUrl]);
                }
            }
        }
        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);

    }
    
   
}
