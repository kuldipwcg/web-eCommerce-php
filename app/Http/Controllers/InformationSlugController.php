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
            "message"=>"success",
            "status"=>200,
        ]);
    }

    public function show($slug)
    {
        $informationSlug=InformationSlug::where("slug",$slug)->first();
        return response()->json([
            "data"=> $informationSlug,
            "message"=>"success",
            "status"=>200,
        ]);
    }

    public function update(Request $request, $slug)
    {
        $informationSlug = InformationSlug::where("slug",$slug)->first();
        $informationSlug->update([
            "description"=> $request->description,
        ]);
        return response()->json([
            "data"=> $informationSlug,
            "message"=>"success",
            "status"=>200,
        ]);
    }
}
