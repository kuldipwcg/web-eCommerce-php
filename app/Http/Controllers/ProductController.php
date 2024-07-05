<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductVariants;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['reviews','product_image', 'product_variants'])->get();

        $formattedProducts = $products->map(function ($product) {
            $colorsId = $product->product_variants->pluck('color_id')->unique()->values()->all();
            $sizesId = $product->product_variants->pluck('size_id')->unique()->values()->all();

            $colors = ProductColor::whereIn('id', $colorsId)->pluck('color');
            $sizes = ProductSize::whereIn('id', $sizesId)->pluck('size');
            // dd($colors);

            $avgRating = Review::where('product_id', $product->id)->avg('rating');


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
                "reviews"=>$product->reviews,
                "totalReviews"=> count($product->reviews),
                "rating_Count"=>$avgRating ? $avgRating : 0,
                'product_images' => $product->product_image->pluck('product_image'),
                // 'product_variants' => $product->product_variants->map(function ($variant) {
                //     return [
                //         'color' => $variant->color_id,
                //         'size' => $variant->size_id,
                //         'quantity' => $variant->quantity,
                //     ];
                // }),
            ];
        });

        return response()->json(['products' => $formattedProducts], 200);
    }


    public function display(Request $request)
    {

        $productColor = [];
        $productSize = [];
        $productPrice = [];
        $productSearch = [];
        $FinalProduct = [];

        //getting the data according to search
        if ($request->has('search')) {
            $productSearch = Product::whereAny(['product_name', 'short_desc', 'description', 'information'], 'like', "%" . $request->search . "%")->get()->toArray();

            $FinalSearch = collect($productSearch)->pluck('id')->toArray();
            $FinalProduct[] = $FinalSearch;

            // dd($productSearch);
        }


        //getting the filtered data
        if ($request->has('filter')) {

            $filter = $request->all()['filter'];

            //products from price filter
            if (array_key_exists('price', $filter)) {

                $len = count($filter['price']);
                $min = $filter['price'][0][0];
                $max = $filter['price'][$len - 1][1];

                $productPrice = Product::whereBetween('price', [$min, $max])
                    ->with(['reviews', 'product_image', 'product_variants'])
                    ->get()->toArray();

                if ($productPrice != []) {
                    $FinalPrice = collect($productPrice)->pluck('id')->toArray();
                    $FinalProduct[] = $FinalPrice;
                }
            }




            //products from size filter

            if (array_key_exists('size', $filter)) {


                foreach ($filter['size'] as $key => $size) {

                    $variant_ids = ProductVariants::where('size_id', $size)->pluck('product_id');

                    foreach ($variant_ids as $key => $id) {

                        $productSize[] = Product::where('id', $id)
                            ->with(['reviews', 'product_image', 'product_variants'])
                            ->get()->toArray();
                    }
                }

                if ($productSize != []) {

                    $FinalSize = collect(array_merge(...$productSize))->pluck('id')->toArray();
                    $FinalProduct[] = $FinalSize;
                }
            }


            //products from color filter

            if (array_key_exists('color', $filter)) {

                foreach ($filter['color'] as $key => $color) {

                    $variant_ids = ProductVariants::where('color_id', $color)->pluck('product_id');

                    foreach ($variant_ids as $key => $id) {

                        $productColor[] = Product::where('id', $id)
                            ->with(['reviews', 'product_image', 'product_variants'])
                            ->get()->toArray();
                    }
                }
                if ($productColor) {
                    $FinalColor = collect(array_merge(...$productColor))->pluck('id')->toArray();
                    $FinalProduct[] = $FinalColor;
                }
            }
        }


        $final = $FinalProduct;
        //intersection of all the filters
        $final  = call_user_func_array('array_intersect', $final);

        $products = Product::whereIn('id', $final)
            ->with(['reviews', 'product_image', 'product_variants'])
            ->get();



        $formattedProducts = $products->map(function ($product) {
            $colorsId = $product->product_variants->pluck('color_id')->unique()->values()->all();
            $sizesId = $product->product_variants->pluck('size_id')->unique()->values()->all();

            $colors = ProductColor::whereIn('id', $colorsId)->pluck('color');
            $sizes = ProductSize::whereIn('id', $sizesId)->pluck('size');
            // dd($colors);

            $avgRating = Review::where('product_id', $product->id)->avg('rating');

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
                "reviews" => $product->reviews,
                "totalReviews" => count($product->reviews),
                "rating_Count" => $avgRating ? $avgRating : 0,
                'product_images' => $product->product_image->pluck('product_image'),
                // 'product_variants' => $product->product_variants->map(function ($variant) {
                //     return [
                //         'color' => $variant->color_id,
                //         'size' => $variant->size_id,
                //         'quantity' => $variant->quantity,
                //     ];
                // }),
            ];
        });

        return response()->json(['products' => $formattedProducts], 200);
    }



    public function store(ProductRequest $request)
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
                'is_featured'=> $request->has('is_featured') ? $request->is_featured : 'false',
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

    public function show($id)
    {
        $products = Product::with(['reviews','product_image', 'product_variants'])->where('id', $id)->get();
        
        if (Product::where('id', $id)->first()) {
            $formattedProducts = $products->map(function ($product) {
                $category = Category::where('id', $product->category_id)->first();
                
                $colorsId = $product->product_variants->pluck('color_id')->unique()->values()->all();
                $sizesId = $product->product_variants->pluck('size_id')->unique()->values()->all();

                $colors = ProductColor::whereIn('id', $colorsId)->pluck('color');
                $sizes = ProductSize::whereIn('id', $sizesId)->pluck('size');

                $avgRating = Review::where('product_id', $product->id)->avg('rating');

                return [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'short_desc' => $product->short_desc,
                    'description' => $product->description,
                    'information' => $product->information,
                    'price' => $product->price,
                    'discount_type' => $product->discount_type,
                    'discount_value' => $product->discount_value,
                    'category'=> $category->category_name,
                    'is_featured' => $product->is_featured,
                    'colors' => $colors,
                'sizes' => $sizes,
                "reviews"=>$product->reviews,
                "totalReviews"=> count($product->reviews),
                "rating_Count"=>$avgRating ? $avgRating : 0,

                    'product_images' => $product->product_image->pluck('product_image'),
                    // 'product_variants' => $product->product_variants->map(function ($variant) {
                    //     return [
                    //         'color' => $variant->color_id,
                    //         'size' => $variant->size_id,
                    //         'quantity' => $variant->quantity,
                    //     ];
                    // }),
                    
                ];
            });

            return response()->json(['Message' => 'Show Method', 'products' => $formattedProducts], 200);
        } else {
            return response()->json([
                'message' => 'Data not found',
                'status' => 'error',
                'code' => 404,
            ], 404);
        }
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
        return response()->json(['message' => 'Product deleted successfully','DeletedProduct'=>$product], 200);
    }


    public function update(ProductRequest $request, $id)
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

        $updatedVariants = [];
        foreach ($request->variants as $key => $value) {

            // dd($value['color']);
            $color = ProductColor::where('color', $value['color'])->first();
            $size = ProductSize::where('size', $value['size'])->first();

            // dd($color->id);
            $variation = ProductVariants::where('color_id', $color->id)->where('size_id', $size->id)->where('product_id', $product->id)->first();


            if ($variation) {
                $v = ProductVariants::find($variation->id);
                $variation->update([
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $value['quantity'],
                ]);
                $updatedVariants[] = $v->id;
                // dd($p->id);
            } else {
                $v = ProductVariants::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $value['quantity'],
                ]);
                $updatedVariants[] = $v->id;
                // dd('no');
            }
        }
        ProductVariants::where('product_id', $product->id)->whereNotIn('id', $updatedVariants)->delete();

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
