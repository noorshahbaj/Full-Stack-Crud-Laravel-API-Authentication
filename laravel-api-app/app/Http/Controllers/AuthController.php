<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Mail\ResetPasswordLink;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        Mail::to($user)->send(new EmailVerification($user));

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'errors' => ['email' => ['The provided credentials are incorrect.']]
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $url = URL::temporarySignedRoute('password.reset', now()->addMinutes(30), ['email' => $request->email]);

        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);

        // Send password reset link
        Mail::to($request->email)->send(new ResetPasswordLink($url));

        return response()->json([
            'message' => 'Password reset link sent on your email id.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return [
                'message' => 'The provided credentials are incorrect.'
            ];
        }

        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'Password reset successfully.'
        ]);
    }

    public function sendEmailVerification(Request $request)
    {
        Mail::to($request->user())->send(new EmailVerification($request->user()));

        return [
            'message' => 'Email verification link sent on your email id.'
        ];
    }

    public function verifyEmail(Request $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
        }

        return [
            'message' => 'Email verified successfully.'
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}
