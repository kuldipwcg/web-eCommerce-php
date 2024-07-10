<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCheck;
use App\Http\Requests\SignupCheck;
use App\Http\Requests\UserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserCheck;


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
    }

    public function login(LoginCheck $request)
    {
        $person = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $person->password)) {
            if ($person->status !== 'active') {
                return response()->json(
                    [
                        'Message' => 'User is not active',
                        'status' => 422,
                    ],
                    422,
                );
            }

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
            ], 200);
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
        $user = auth()->user()->token();
        $user->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
            'status_code' => 200
        ], 200);
    }

    public function index()
    {

        $user = User::latest()->paginate(10);
        if ($user) {
            return response()->json([
                'type' => 'success',
                'message' => 'User profile displayed successfully',
                'code' => 200,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'something went wrong',
                'code' => 404,

            ]);
        }
    }

    public function store(UserRequest $request)
    {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('/upload/userProfile/'), $imageName);
        $profileUrl = url('/upload/userProfile/' . $imageName);
        // $user = User::create($request->all());

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'phoneNo' => $request->phoneNo,
            'dob' => $request->dob,
            'image' => $profileUrl,

        ]);
        if ($user) {
            return response()->json([
                'type' => 'success',
                'message' => 'User profile added successfully',
                'code' => 200,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'something went wrong',
                'code' => 404,

            ]);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                'type' => 'success',
                'message' => 'User profile displayed successfully',
                'code' => 200,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'something went wrong',
                'code' => 404,

            ]);
        }
    }

    public function update(Request $request)
    {

        // dd($request);

        $id = auth()->user()->id;

        $user = User::find($id);

        if ($user) {

            $input = $request->all();

            $user->fill($input)->save();


            $image = $request->file('image');

            if ($image == null) {
                
                $profileUrl = null;
            
            } else {                
                
                if($user->image)
                {
                    unlink(public_path($user->image));
                }
                
                $imageName = time() . $image->getClientOriginalName();
                $image->move(public_path('/upload/userProfile/'), $imageName);
                $profileUrl = '/upload/userProfile/' . $imageName;
                
            }

                $user->firstName = $request->firstName ?: $user->firstName;
                $user->lastName = $request->lastName ?: $user->lastName;
                $user->email = $request->email ?: $user->email;
                $user->image = $profileUrl ?: $user->image;
                $user->dob = $request->dob ?: $user->dob;
                $user->phoneNo = $request->phoneNumber ?: $user->phoneNo;
                $user->address = $request->address ?: $user->address;
                $user->save();

            return response()->json([
                'type' => 'success',
                'message' => 'User profile Updated successfully',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'something went wrong',
                'code' => 404,
            ]);
        }
    }
}
