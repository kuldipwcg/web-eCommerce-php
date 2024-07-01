<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    public function index()
    {

        return response()->json([
            'Data'=>Banner::latest()->paginate(10),
            'massage' => "success",
            'status' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $bannerImage = $request->file('banner_image');
        $imageName = time() . $bannerImage->getClientOriginalName();

        $bannerImage->move(public_path('/upload/banners/'), $imageName);

        $record = Banner::create([
            'banner_image' => $imageName,
            'banner_title' => $request->banner_title,
            'banner_desc' => $request->banner_desc,
            'banner_link' => $request->banner_link,
        ]);
        return response()->json([
            'data' => $record,
            'massage' => "Banner updated successfully",
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $color = Banner::findOrFail($id);
        return response()->json($color, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $bannerImage = $request->file('banner_image');

        // $oldImageName = public_path() .$banner->banner_image;
        // unlink($oldImageName);

        $imageName = time() . $bannerImage->getClientOriginalName();
        $bannerImage->move(public_path('/upload/banners/'), $imageName);

        $banner->update([
            'banner_image' => $imageName,
            'banner_title' => $request->banner_title,
            'banner_desc' => $request->banner_desc,
            'banner_link' => $request->banner_link,
        ]);
        return response()->json([
            "data" => $banner,
            'massage' => "Banner updated successfully",
            "status" => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $color = Banner::findOrFail($id);
        $color->delete();
        return response()->json([
            'massage' => "Banner deleted successfully",
            "status" => 200
        ]);
    }
}
