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
            'data' => Banner::latest()->paginate(10),
            'message' => "success",
            'status' => 200
        ]);
    }

    public function store(BannerRequest $request)
    {
        $bannerImage = $request->file('banner_image');
        $imageName = time() . $bannerImage->getClientOriginalName();
        $bannerImage->move(public_path('/upload/banners/'), $imageName);
        $bannerUrl = '/upload/banners/' . $imageName;

        $record = Banner::create([
            'banner_image' => $bannerUrl,
            'banner_title' => $request->banner_title,
            'banner_desc' => $request->banner_desc,
            'banner_link' => $request->banner_link,
        ]);
        return response()->json([
            'data' => $record,
            'message' => "Banner updated successfully",
            'status' => 200
        ]);
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return response()->json($banner, 200);
    }

    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $bannerImage = $request->file('banner_image');

            if ($bannerImage == null) {

                $bannerUrl = $banner->banner_image;

            } else {

                if ($banner->banner_image) {
                    unlink(public_path().$banner->banner_image);
                }

                $imageName = $bannerImage->getClientOriginalName();
                $bannerImage->move(public_path('/upload/banners/'), $imageName);
                $bannerUrl = '/upload/banners/' . $imageName;
            }

            $banner->update([
                'banner_image' => $bannerUrl,
                'banner_title' => $request->banner_title,
                'banner_desc' => $request->banner_desc,
                'banner_link' => $request->banner_link,
            ]);

            return response()->json([
                "data" => $banner,
                'message' => "Banner updated successfully",
                "status" => 200
            ]);

        } else {
            return response()->json([
                'message' => "data not found",
                "status" => 404
            ], 404);
        }
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return response()->json([
            'message' => "Banner deleted successfully",
            "status" => 200
        ]);
    }
}
