<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginCheck;
use App\Http\Requests\UpdateUserCheck;
use Illuminate\Support\Facades\Hash;
use Exception;


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
             
                return response()->json(['token' => $token,'message'=>'login successfully'], 200);
            } else {
                return response()->json(['error' => 'Unauthorized'], 402);
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
            return response()->json(['error' => 'Unauthorized'], 402);
        }
    }

    //changing password
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
                    'message' => 'Error occured',

                ],
                500

            );
        }
    }

    public function logout(Request $request)
    {

        $user = auth()->user()->token();
        $user->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
            'status_code' => 200
        ], 200);
    } 

    public function update(UpdateUserCheck $request)
    {

        $id = auth()->guard('admin')->user()->id;

        $user = Admin::find($id);

        if ($user) {

            $image = $request->file('image');
            if ($image == null) {

                $profileUrl = null;
            } else {

                if($user->image)
                {
                    unlink(public_path($user->image));
                }

                $imageName = $image->getClientOriginalName();
                $image->move(public_path('/upload/adminProfile/'), $imageName);
                $profileUrl = '/upload/adminProfile/' . $imageName;
                
            }

            $user->firstName = $request->firstName ?: $user->firstName;
            $user->lastName = $request->lastName ?: $user->lastName;
            $user->email = $request->email ?: $user->email;
            $user->image = $profileUrl ?: $user->image;
            $user->phoneNumber = $request->phoneNumber ?: $user->phoneNumber;
            $user->save();

            return response()->json([
                'type' => 'success',
                'message' => 'User profile Updated successfully',
                'data' => $user,
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'User not found',
                'code' => 500,
            ]);
        }
    }


}
