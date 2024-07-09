<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footer;

class FooterController extends Controller
{   


    public function index(){
        $data = Footer::all();
        if($data){            
            return response()->json(
                ['footer'=> $data,
                ],200);
                    
        }else{
            return response()->json(
                ['message'=> 'No Data Found'
            ],404);
        }
    } 


    public function update(Request $request,$id)
    {
        $footer = Footer::find($id);
        if($footer){
            $footer->update([
                'description' => $request->description,
                'email' =>  $request->email,
                'address' => $request->address,
                'contact' => $request->contact,
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'linkedIn' => $request->linkedIn,
                'instagram' => $request->instagram,
            ]);
            return response()->json([
                "data" => $footer,
                'massage' => "footer updated successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                'massage' => "Data not found",
                "status" => 404
            ]);
        }
    }
}
