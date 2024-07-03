<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginCheck;
use App\Http\Requests\SignupCheck;
use App\Models\User;
use function Laravel\Prompts\password;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function signup(SignupCheck $request)
    {
        // dd($request->all());
        if ($request->password == $request->confirmPassword) {
            $data = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'confirmPassword' => Hash::make($request->confirmPassword),
            ];

            DB::table('users')->insert($data);

            return response()->json([
                'Message' => 'User created successfully',
            ]);
        } else {
            return response()->json([
                'Message' => 'Password and Confirm Password should be same',
            ]);
        }

        // $user = User::create([
        //     'id'=>Str::uuid(),
        //     'first_name' => $request->first_name,
        //     'last_name' => $request->last_name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'confirm_password' => Hash::make($request->confirm_password),
        // ]);



    }

    public function login(LoginCheck $request)
    {

        $person = User::where('email', $request->email)->first();

        if ($person && Hash::check($request->password, $person->password)) {
            auth('api')->setUser($person);
            $token = $person->createToken('user-auth')->accessToken;
            $name = $person->firstName;
            return response()->json([
                'message' => 'Successfully logged-in',
                'name' => $name,
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Credential are wrong',
            ], 402);
            // return 'error';
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


    public function logout(Request $request)
    {


        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Logged out successfully!',
            'status_code' => 200
        ], 200);
    }
}
