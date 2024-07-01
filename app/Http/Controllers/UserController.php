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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

class UserController extends Controller
{

    public function signup(SignupCheck $request)
    {
        // dd($request->all());
        if($request->password == $request->confirmPassword){
            $data = [   
                'id' =>Str::uuid(),
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

        }
        else{
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



    public function login(LoginCheck $request){

        $person = User::where('email',$request->email)->first();

        if($person && Hash::check($request->password,$person->password))
        {
            $token = $person->createToken('user-auth')->accessToken;
            $name = $person->firstName;
            return response()->json([
                'message' => 'Successfully logged-in',
                'name'=> $name,
                'token' => $token,
            ],200);

        }
        else{
            return response()->json([
                'message' => 'Credential are wrong',
            ],200);
            // return 'error';
         }
    } 
    //logout 

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Logged out failed',
            ], 401);
        }
    }
}
