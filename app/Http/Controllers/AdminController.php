<?php namespace App\Http\Controllers;

use Exception;

<<<<<<< HEAD
use App\Models\User;
=======
>>>>>>> 1543e4d (#123: [Product-Searching, Cart] >>> Searching in product and cart logics)
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\LoginCheck;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserCheck;

class AdminController extends Controller
{
    public function setAdmin(LoginCheck $request)
    {
        // Check if admin already exists
        $admin = Admin::where('email', $request->email)->first();

        // Create new admin
        if (!$admin) {
            $data = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];

            DB::table('admins')->insert($data);

            return response()->json(
                [
                    'admin' => $admin,
                    'Message' => 'Admin created successfully',
                    'status' => 200,
                ],
                200,
            );
        }

        return response()->json(
            [
                'admin' => $admin,
                'Message' => 'Admin already exists',
                'status' => 200,
            ],
            200,
        );
    }

    public function login(LoginCheck $request)
    {
        // get the admin
        $admin = Admin::where('email', $request->email)->first();

        // password checking
        try {
            if ($admin && Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('AdminToken')->accessToken;

                return response()->json(['token' => $token, 'message' => 'login successfully'], 200);
            } else {
                return response()->json(['error' => 'Unauthorized'], 200);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    //changing password
    public function change(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        $id = $admin->id;

        if (Hash::check($request->currentPassword, $admin->password)) {
            Admin::where('id', $id)->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json(
                [
                    'message' => ' Password Changed',
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'message' => 'Current password and existing password are not matched',
                ],
                200,
            );
        }
    }

    public function logout(Request $request)
    {
        $admin = auth()->guard('admin')->user()->token();
        $admin->delete();

        return response()->json(
            [
                'message' => 'Logged out successfully!',
                'status_code' => 200,
            ],
            200,
        );
    }

    public function displayUser()
    {
        $user = User::latest()->paginate(10);
        if ($user) {
            return response()->json([
                'type' => 'success',
                'message' => 'Users fetched successfully',
                'code' => 200,
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'type' => 'failure',
                'message' => 'User not found',
                'code' => 200,
            ]);
        }
    }

    public function update(UpdateUserCheck $request)
    {
        $id = auth()->guard('admin')->user()->id;

        $admin = Admin::find($id);

        $image = $request->file('image');
        if ($image == null) {
            $profileUrl = null;
        } else {
            if ($admin->image) {
                unlink(public_path($admin->image));
            }

            $imageName = $image->getClientOriginalName();
            $image->move(public_path('/upload/adminProfile/'), $imageName);
            $profileUrl = '/upload/adminProfile/' . $imageName;
        }

        $admin->firstName = $request->firstName ?: $admin->firstName;
        $admin->lastName = $request->lastName ?: $admin->lastName;
        $admin->email = $request->email ?: $admin->email;
        $admin->image = $profileUrl ?: $admin->image;
        $admin->phoneNumber = $request->phoneNumber ?: $admin->phoneNumber;
        $admin->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Admin profile Updated successfully',
            'data' => $admin,
            'code' => 200,
        ]);
    }
}
