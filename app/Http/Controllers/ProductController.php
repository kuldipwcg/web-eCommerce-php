<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;

class ProductController extends Controller
{
    public function show($id)
    {

        $products = Product::with(['product_image', 'product_variants'])->where('id', $id)->get();
        if (!Product::where('id', $id)->first()) {
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

            return response()->json(['Mesaage' => 'Show Method', 'products' => $formattedProducts], 200);
        } else {
            return response()->json([
                'message'=> 'Data not found',
                'status'=>'error',
                'code'=>404,
            ],404);
        }
    }
}
