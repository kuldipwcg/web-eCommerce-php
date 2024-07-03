<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\SignupCheck;
use App\Models\User;
use Exception;


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
           
        // password checking
        if ($admin && Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('AdminToken')->accessToken;

            // dd($token);

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function change(Request $request)
    {

        $id = auth()->user()->id;

        if (Hash::check($request->currentPassword, auth()->user()->password)) {

            User::where('id', $id)
                ->update([
                    'password' => Hash::make($request->password),
                ]);

            return response()->json(

                [
                    'message' => ' Password Changed',

                ],
                200

            );
        } else {

            return response()->json(

                [
                    'message' => ' Error  Changed',

                ],
                200

            );
        }
    }

    // public function logout(Request $request)
    // {

    //     $user = Auth::user()->token();
    //     $user->revoke();

    //     return response()->json([
    //         'message' => 'Logged out successfully!',
    //         'status_code' => 200
    //     ], 200);
    // }
}
