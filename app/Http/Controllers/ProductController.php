<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductVariants;
use App\Http\Requests\ProductRequest;
use Illuminate\Pagination\LengthAwarePaginator;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['reviews', 'product_image', 'product_variants'])->paginate(10);

        $formattedProduct = $products->map(function ($product) {
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
                'is_featured' => $product->is_featured,
                'colors' => $colors,
                'sizes' => $sizes,
                'reviews' => $product->reviews,
                'totalReviews' => count($product->reviews),
                'rating_Count' => $avgRating ? $avgRating : 0,
                'product_images' => $product->product_image->pluck('product_image'),
            ];
        });

        $paginateProduct = (new LengthAwarePaginator(
            $formattedProduct,
            $products->total(),
            $products->perPage(),
            $products->currentPage(),
    
            ['path' => request()->url(), 'query'=> request()->query()]
    
        ));
        
        return response()->json($paginateProduct, 200);
    }

    
public function display(Request $request)
{

    $productColor = [];
    $productSize = [];
    $productPrice = [];
    $productSearch = [];
    $finalProduct = [];

    //getting the data according to search
    if ($request->has('search')) {


        foreach (explode(" ", $request->search) as $str) {

            $colorId = ProductColor::where('color', 'like', "%" . $str . "%")->pluck('id')->first();

            $pIdForColor = ProductVariants::where('color_id', $colorId)->pluck('product_id')->toArray();
            $productSearch[] = Product::where('id', $pIdForColor)->get()->toArray();


            $sizeId = ProductSize::where('size', 'like', "%" . $str . "%")->pluck('id')->first();
            $pIdForSize = ProductVariants::where('size_id', $sizeId)->pluck('product_id')->toArray();
            $productSearch[] = Product::where('id', $pIdForSize)->get()->toArray();

            $productSearch[] = Product::with(['reviews', 'product_image', 'product_variants'])->whereAny(['product_name', 'short_desc', 'description', 'information'], 'like', "%" . $request->search . "%")->get()->toArray();
        }

        $productSearch = array_merge(...$productSearch);
        $finalSearch = collect($productSearch)->pluck('id')->toArray();
        $finalProduct[] = $finalSearch;
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
                $finalPrice = collect($productPrice)->pluck('id')->toArray();
                $finalProduct[] = $finalPrice;
            }
        }

        //products from size filter

        if (array_key_exists('size', $filter)) {


            foreach ($filter['size'] as $key => $size) {

                $variantIds = ProductVariants::where('size_id', $size)->pluck('product_id');

                foreach ($variantIds as $key => $id) {

                    $productSize[] = Product::where('id', $id)
                        ->with(['reviews', 'product_image', 'product_variants'])
                        ->get()->toArray();
                }
            }

            if ($productSize != []) {

                $finalSize = collect(array_merge(...$productSize))->pluck('id')->toArray();
                $finalProduct[] = $finalSize;
            }
        }


        //products from color filter

        if (array_key_exists('color', $filter)) {

            foreach ($filter['color'] as $key => $color) {

                $variantIds = ProductVariants::where('color_id', $color)->pluck('product_id');

                foreach ($variantIds as $key => $id) {

                    $productColor[] = Product::where('id', $id)
                        ->with(['reviews', 'product_image', 'product_variants'])
                        ->get()->toArray();
                }
            }
            if ($productColor) {
                $finalColor = collect(array_merge(...$productColor))->pluck('id')->toArray();
                $finalProduct[] = $finalColor;
            }
        }
    }


    $final = $finalProduct;

    //intersection of all the filters
    if ($final) {
        $final  = call_user_func_array('array_intersect', $final);
    }

    $products = Product::whereIn('id', $final)
        ->with(['reviews', 'product_image', 'product_variants'])
        ->paginate(10);


    $formattedProducts = $products->map(function ($product) {
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
            'is_featured' => $product->is_featured,
            'colors' => $colors,
            'sizes' => $sizes,
            "reviews" => $product->reviews,
            "totalReviews" => count($product->reviews),
            "rating_Count" => $avgRating ? $avgRating : 0,
            'product_images' => $product->product_image->pluck('product_image'),

        ];
    });

        return response()->json(['products' => $formattedProducts], 200);
    }

    public function store(ProductRequest $request)
    {
        $category = Category::where('category_name', $request->category_name)->first();
        if (!$category || $category->status !== 'active') {
            return response()->json(
                [
                    'Message' => 'Category is not active or not available.',
                    'status' => 200,
                ],
                200,
            );
        }

        $product = Product::create([
            'product_name' => $request->product_name,
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'information' => $request->information,
            'price' => $request->price,
            'category_id' => $category->id,
            'is_featured' => $request->has('is_featured') ? $request->is_featured : 'false',
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
        ]);

        foreach ($request->variants as $v) {
            $color = ProductColor::where('color', $v['color'])->first();
            $size = ProductSize::where('size', $v['size'])->first();

            if (!$color || $color->status !== 'active') {
                return response()->json(
                    [
                        'Message' => 'Color is not active or not available.',
                        'status' => 200,
                    ],
                    200,
                );
            }
            if (!$size || $size->status !== 'active') {
                return response()->json(
                    [
                        'Message' => 'Size is not active or not available.',
                        'Status' => 200,
                    ],
                    200,
                );
            }

            ProductVariants::create([
                'product_id' => $product->id,
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
                    'product_id' => $product->id,
                    'product_image' => $productimg,
                ]);
            }
        } else {
            return response()->json(
                [
                    'Message' => 'Image Not found',
                    'status' => 200,
                ],
                200,
            );
        }

        return response()->json(['Message' => 'Product Added Successfully', 'status' => 200, 'products' => $product], 200);
    }

    public function show($id)
    {
        $products = Product::with(['reviews', 'product_image', 'product_variants'])->where('id', $id)->get();
        if (!$products) {
            return response()->json(
                [
                    'Message' => 'Product data is not available',
                    'status' => 200,
                ],
                200,
            );
        }

        if (Product::where('id', $id)->first()) {
            $product = $products->map(function ($product) {
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
                    'category' => $category->category_name,
                    'is_featured' => $product->is_featured,
                    'colors' => $colors,
                    'sizes' => $sizes,
                    'Reviews' => $product->reviews,
                    'totalReviews' => count($product->reviews),
                    'Rating_Count' => $avgRating ? $avgRating : 0,
                    'product_images' => $product->product_image->pluck('product_image'),
                ];
            });

            return response()->json(['status' => 200, 'products' => $product], 200);
        } else {
            return response()->json(
                [
                    'Message' => 'Product data is not available',
                    'status' => 200,
                ],
                200,
            );
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'Message' => 'Product data is not available',
                    'status' => 200,
                ],
                200,
            );
        }

        $product->product_variants()->delete();
        $product->product_image()->delete();
        $product->delete();
        return response()->json(['Message' => 'Product deleted successfully', 'status' => 200], 200);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'Message' => 'Product data is not available',
                    'status' => 200,
                ],
                200,
            );
        }

        $category = Category::where('category_name', $request->category_name)->first();
        if (!$category) {
            return response()->json(
                [
                    'Message' => 'Category is not available.',
                    'status' => 200,
                ],
                200,
            );
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
            $color = ProductColor::where('color', $value['color'])->first();
            $size = ProductSize::where('size', $value['size'])->first();

            $variation = ProductVariants::where('color_id', $color->id)->where('size_id', $size->id)->where('product_id', $product->id)->first();

            if ($variation) {
                $v = ProductVariants::find($variation->id);
                $variation->update([
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $value['quantity'],
                ]);
                $updatedVariants[] = $v->id;
            } else {
                $v = ProductVariants::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => $value['quantity'],
                ]);
                $updatedVariants[] = $v->id;
            }
        }
        ProductVariants::where('product_id', $product->id)
            ->whereNotIn('id', $updatedVariants)
            ->delete();

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
        return response()->json(['Message' => 'Product updated successfully', 'status' => 200, 'product' => $product], 200);
    }

    public function productstatus(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'Message' => 'Product is not available',
                    'status' => 200,
                ],
                200,
            );
        }
        $product->status = $request->status;
        $product->save();

        return response()->json(['Message' => 'Product status updated successfully']);
    }

    public function isFeatured()
    {
        $featured = Product::where('is_featured', 'true')->get();
        if ($featured) {
            return response()->json(['is_featured' => $featured,],200);
        } else {
            return response()->json(['message' => 'Data not found',],200);
        }   
    }
}
