<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // ✅ Add this
use Illuminate\Validation\ValidationException; // ✅ And this
use App\Models\User;

class AuthController extends Controller
{
    public function registerUsingEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'verification_code' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)
                   ->where('code', $request->verification_code)
                   ->whereNotNull('email_verified_at')
                   ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code or email not verified.',
            ], 404);
        }

        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->code = null;
        $user->save();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully via email',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function registerUsingPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $phone = $this->formatPhoneNumber($request->phone);

        $user = User::where('user_phone', $phone)
                   ->whereNotNull('phone_verified_at')
                   ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Phone not verified or user not found',
            ], 404);
        }

        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->code = null;
        $user->save();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully via phone',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function checkEmailExistence(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $exists = User::where('email', $request->email)
                     ->whereNotNull('email_verified_at')
                     ->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 2) === '03' && strlen($phone) === 11) {
            $phone = '92' . substr($phone, 1);
        }
        return $phone;
    }

    /* Login Methods by email */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
            'method' => 'required|in:email,phone'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $credentials = $this->getCredentials($request);
            
            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'login' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = $request->user();
            
            // Revoke existing tokens
            $user->tokens()->delete();
            
            // Create new token
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'token_type' => 'Bearer'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 401);
        }
    }

    private function getCredentials($request)
    {
        if ($request->method === 'email') {
            return [
                'email' => $request->login,
                'password' => $request->password
            ];
        }

        return [
            'user_phone' => $this->formatPhoneNumber($request->login),
            'password' => $request->password
        ];
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }
}