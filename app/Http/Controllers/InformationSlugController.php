<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationSlugRequest;
use App\Models\InformationSlug;
use Illuminate\Http\Request;

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

    public function store(Request $request)
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

    public function update(Request $request, $slug)
    {
        // dd($slug,$request->all());
        $informationSlug = InformationSlug::where("slug",$slug)->first();
        $informationSlug->update([
            "description"=> $request->description,
        ]);
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
