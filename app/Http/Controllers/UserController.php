<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCheck;
use App\Http\Requests\SignupCheck;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signup(SignupCheck $request)
    {
        $data = [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmPassword' => Hash::make($request->confirmPassword),
        ];

        DB::table('users')->insert($data);

        return response()->json(
            [
                'user-data' => $data,
                'Message' => 'User created successfully',
                'status' => 200,
            ],
            200,
        );
    }

    public function login(LoginCheck $request)
    {

        $person = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $person->password)) {
            if ($person->status !== 'active') {
                return response()->json(
                    [
                        'message' => 'User is not active',
                        'status' => 200,
                    ],
                    200,
                );
            }

            $token = $person->createToken('user-auth')->accessToken;
            $data = ['person' => $person, 'token' => $token];
            return response()->json(
                [
                    'data' => $data,
                    'message' => 'Successfully logged-in',
                    'status' => 200,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'message' => 'Credential are wrong',
                    'status' => 200,
                ],
                200,
            );
        }
    }

    public function change(Request $request)
    {
        $id = auth()->user()->id;

        if (Hash::check($request->currentPassword, auth()->user()->password)) {
            User::where('id', $id)->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json(
                [
                    'message' => ' Password Changed',
                    'status' => 200,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'message' => ' Password is not changed',
                    'status' => 200,
                ],
                200,
            );
        }
    }

    public function logout(Request $request)
    {

        $user = auth()->user()->token();
        $user->delete();

        return response()->json(
            [
                'data' => $user,
                'message' => 'Logged out successfully!',
                'status_code' => 200,
            ],
            200,
        );
    }

    public function update(UpdateUserCheck $request)
    {
        $id = auth()->user()->id;
        $user = User::find($id);

        $image = $request->file('image');

        if ($image == null) {
            $profileUrl = null;
        } else {
            if ($user->image) {
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

        return response()->json(
            [
                'data' => $user,
                'type' => 'success',
                'message' => 'User profile Updated successfully',
                'status' => 200,
            ],
            200,
        );
    }

    public function userStatus(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();
        return response()->json([
            'message' => 'User status updated successfully.',
            'status' => 200,
        ],200);
    }
}
