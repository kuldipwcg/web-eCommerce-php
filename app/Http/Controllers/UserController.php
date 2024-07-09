<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginCheck;
use App\Http\Requests\SignupCheck;
use App\Http\Requests\UpdateUserCheck;
use App\Http\Requests\UserRequest;
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
                'user-data' => $data,
                'Message' => 'User created successfully',
                'status'=> 200,

            ],200);
        } else {
            return response()->json([
                'Message' => 'Password and Confirm Password should be same',
                'status'=> 404,
            ],404);
        }
    }

    public function login(Request $request)
    {

        $person = User::where('email', $request->email)->first();

        // dd($person);

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
                'status'=> 404,
            ], 404);
            // return 'error';
        }
    }
    //logout 

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
                    'status'=> 200,                   
                ],
                200
            );
        } else {

            return response()->json(
                [
                    'message' => ' Error  Occureed',
                    'status'=> 404,                   
                ],
                404
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

   
    public function update(UpdateUserCheck $request)
    {
        $id = auth()->user()->id;   
        $user = User::find($id);
     
        if ($user) {

            $image = $request->file('image');

            if ($image == null) {
                
                $profileUrl = null;
            
            } 
            else {                
                
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