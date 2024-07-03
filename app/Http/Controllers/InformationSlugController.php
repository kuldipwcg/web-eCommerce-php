<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationSlugRequest;
use App\Models\InformationSlug;

class InformationSlugController extends Controller
{
    public function index()
    {
        $informationSlug = InformationSlug::all();
        return response()->json([
            "data"=> $informationSlug,
            "status"=>"success",
            "code"=>200,
        ]);
    }

    public function store(InformationSlugRequest $request)
    {
        $informationSlug = InformationSlug::create($request->all());
        return response()->json([
            "data"=> $informationSlug,
            "status"=>"success",
            "code"=>200,
        ]);
    }

    public function show($slug)
    {
        $description=InformationSlug::where("slug",$slug)->first();
        return response()->json([
            "slug"=>$slug,
            "description"=> $description,
            "status"=>"success",
            "code"=>200,
        ]);
    }

    public function update(InformationSlugRequest $request)
    {
        $slug=$request->slug;
        $informationSlug = InformationSlug::where("slug",$slug)->first();
        $informationSlug->update($request->all());
        return response()->json([
            "description"=> $informationSlug,
            "status"=>"success",
            "code"=>200,
        ]);
    }

    public function destroy($id)
    {
        InformationSlug::where("slug",$id)->delete();
    }
}
