<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $validate=[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'unique|required',
            'password' => 'min:8|required|confirmed',
        ];    
        
        if($validate->fails()){
            return response([
                'error'=>$validate->errors()->all()
            ], 422);
        } 
        else{
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }
        
        return response()->json([
            'msg' => "sign up successfully",
            'status' => 200,
        ]);
    }
}
