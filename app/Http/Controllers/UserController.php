<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCheck;
use App\Http\Requests\SignupCheck;
use App\Http\Requests\UpdateUserCheck;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordCheck;

class UserController extends Controller
{

    // to create a new user
    public function signup(SignupCheck $request)
    {
            $data = [   
                
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            DB::table('users')->insert($data);

            return response()->json([
                'user-data' => $data,
                'Message' => 'User created successfully',
                'status'=> 200,

            ],200);
        
    }

    public function login(LoginCheck $request)
    {

        $person = User::where('email', $request->email)->first();

        if($person){

        if (Hash::check($request->password, $person->password)) {
            $token = $person->createToken('user-auth')->accessToken;
            $data =['person'=>$person,'token'=>$token];
            return response()->json([
                'data' => $data,
                'message' => 'Successfully logged-in',
                'status'=> 200,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Credential are wrong',
                'status'=> 500,
            ], 500);
        }
    }
    else{

        return response()->json([
            'message' => 'User not found',
            'status'=> 500,
        ], 500);

    }
    }

    // changing password
    public function change(ChangePasswordCheck $request)
    {
        $id = auth()->user()->id;

        if (Hash::check($request->currentPassword, auth()->user()->password)) {

            User::where('id', $id)
                ->update([
                    'password' => Hash::make($request->password),
                ]);

            return response()->json(
                [
                    'message' => ' Password changed',
                    'status'=> 200,                   
                ],
                200
            );
        } else {

            return response()->json(
                [
                    'message' => ' Password is not changed',
                    'status'=> 500,                   
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
            'data' => $user,
            'message' => 'Logged out successfully!',
            'status_code' => 200
        ], 200);
    }

    
    // updating a profile
    public function update(UpdateUserCheck $request)
    {
        $id = auth()->user()->id;   
        $user = User::find($id);
     
        if ($user) {

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
                $user->phoneNo = $request->phoneNumber ?: $user->phoneNumber;
                $user->address = $request->address ?: $user->address;
                $user->save();

            return response()->json([
                'data' => $user,
                'type' => 'success',
                'message' => 'User profile Updated successfully',
                'status'=> 200,
            ],200);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'User not found',
                'status'=> 500,
            ],500);
        }
    }
}
