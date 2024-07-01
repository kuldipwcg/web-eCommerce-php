<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCheck;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function setAdmin(LoginCheck $request)
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


public function login(LoginCheck $request)
{
    // get the admin
    $admin = Admin::where('email', $request->email)->first();   

    // dd($admin);


    // password checking
    if ($admin && Hash::check($request->password, $admin->password)) {
        $token = $admin->createToken('AdminToken')->accessToken;

        // dd($token);

        return response()->json(['token' => $token], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
}