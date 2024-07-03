<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footer;

class FooterController extends Controller
{   


    public function index(){

        $data = Footer::find(1);
        if($data){            
            return response()->json(
                [
                    'footer'=> $data,
                    
                    ]
                    ,200);
                    
        }else{
            return response()->json(
                [
                    'Error'=> 'Data Not Found',
                    ]
                    ,400);
        }
    } 

    public function store(Request $request){
        $data = Footer::create([
            'description' => $request->description,
            'email' =>  $request->email,
            'address' => $request->address,
            'contact' => $request->contact,
            'twitter' => $request->twitter,
            'facebook' => $request->facebook,
            'linkedIn' => $request->linkedIn,
            'instagram' => $request->instagram,
        ]);
        return response()->json(['message'=>'Footer Data added successfully',
         'data' => $data, 'status' => 200]);
    } 

    public function update(Request $request)
    {
        $footer = Footer::get()->first();
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
}
