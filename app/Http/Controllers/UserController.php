<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

use function Laravel\Prompts\password;

class UserController extends Controller
{

    public function signup(Request $request)
    {
        // dd($request->all());
        $validated = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if($request->password == $request->confirm_password){


            $data = [

                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'confirm_password' => Hash::make($request->confirm_password),
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



    public function login(Request $request){

        $person = User::where('email',$request->email)->first();

        if(Hash::check($request->password,$person->password))
        {

            $token = $person->createToken('user-auth')->accessToken;

            $name = $person->name;

            return response()->json([

                'message' => 'Successfully logged-in',
                'name'=>$name,
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

}
