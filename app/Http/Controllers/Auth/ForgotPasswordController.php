<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\ResetMailCheck;
use App\Http\Requests\ResetPasswordCheck;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;


class ForgotPasswordController extends Controller
{

    public function sendResetLinkEmail(ResetMailCheck $request)
    {

        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent']);
        } else {
            return response()->json(['message' => 'Unable to send reset link'], 200);
        }
    }


    //resetting password
    public function updatePassword(ResetPasswordCheck $request)
    {
        //with guest api
        $this->middleware('guest');

        try {

            // reset function to reset the password
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {

                    //bypassing mass assignment protection
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ]);

                    $user->save();

                    // event is dispatched for reset password
                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return response()->json(['message' => 'Password has been reset successfully.', 'code' => 200], 200);
            } elseif ($status === Password::INVALID_TOKEN) {
                return response()->json(['error' => 'Reset Password link expired, Please request a new password reset link via forgot password.', 'code' => 200], 200);
            } else {
                return response()->json(['error' => 'Password reset failed.', 'code' => 200], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'code' => '200',
            ], 200);
        }
    }
}
