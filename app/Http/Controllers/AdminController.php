<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCheck;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SignupCheck;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function setAdmin(Request $request)
    {

    // Check if admin already exists
    $admin = Admin::where('email', $request->email)->first();

    // Update that existing admin
    if ($admin) {
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();
    } else {
        // Create new admin
        $admin = Admin::create([
            'id' => Str::uuid(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    return response()->json(['admin' => $admin], 200);
}


    public function login(Request $request)
    {
        // get the admin
        $admin = Admin::where('email', $request->email)->first();   

        // password checking
        try {
            if ($admin && Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('AdminToken')->accessToken;
                // dd($token);
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        catch(Exception $e){
            return $e;
        }
           
    }
}
