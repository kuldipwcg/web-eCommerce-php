<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginCheck;
use App\Http\Requests\SignupCheck;
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
        $imageName = time() . $image->getClientOriginalName();
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
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('/upload/userProfile/'), $imageName);
                $profileUrl = url('/upload/userProfile/' . $imageName);

                $user->fill(['image' => $profileUrl])->save();
            }

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
