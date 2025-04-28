<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Language;




class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|exists:users,phone',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Check if user exists and verify password
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate and return API token
        $token = $user->createToken('API Token')->plainTextToken;
        $lang=Language::where('id',$user->language_id)->first();
        return response()->json([
            'message' => 'Login successful!',
            'user' => $user,
            'language' => $lang,
            'token' => $token,
        ], 200);
    }



    public function register(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'cuntry_code' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
            'language_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Format phone number
        $phone = $request->phone;
        if (!str_starts_with($phone, $request->cuntry_code)) {
            $phone = $request->cuntry_code . ltrim($phone, '0'); // Ensure correct international format
        }

        // Check OTP rate limit (1 per minute)
        if (Cache::has("otp_limit_$phone")) {
            return response()->json(['message' => 'Please wait before requesting another OTP.'], 429);
        }
        Cache::put("otp_limit_$phone", true, 60); // Lock for 1 minute

        // Generate OTP code
        $otp = rand(100000, 999999);

        // Store OTP in database with expiry
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $phone,
            'password' => Hash::make($request->password),
            'role_id' => 1,
            'verify_code' => $otp,  // Save OTP in database
            'language_id' => $request->language_id,
            'cuntry_code' => $request->cuntry_code,
        ]);

        // Send OTP via SMS using BulkGate API
      /*   $response = Http::post('https://portal.bulkgate.com/api/1.0/simple/transactional', [
            'application_id' => env('BULKGATE_APP_ID'),
            'application_token' => env('BULKGATE_API_KEY'),
            'number' => $phone,
            'text' => "Your verification code is: $otp",
            'sender_id' => env('BULKGATE_SENDER'),
        ]); */

        // Check if the SMS was successfully sent
        /* if (!$response->successful()) {
            return response()->json([
                'message' => 'Failed to send OTP.',
                'error' => $response->json(),
            ], 500);
        } */

        // Generate API token
        $token = $user->createToken('API Token')->plainTextToken;
        $lang=Language::where('id',$user->language_id)->first();
        return response()->json([
            'message' => 'User registered successfully! Please check your phone for the OTP.',
            'user' => $user,
            'language' => $lang,
            'token' => $token,
        ], 201);
    }

    public function verifyOTP(Request $request)
    {
        // Validate request
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string',
        ]);

        // Find user by phone number
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if OTP matches
        if ($user->verify_code == $request->otp) {
            // OTP is correct, clear it
            $user->verify_code = null;
            $user->phone_verified_at = now();
            $user->is_verify = 1;
            $user->save();

            return response()->json(['message' => 'OTP verified successfully']);
        }

        return response()->json(['message' => 'Invalid OTP'], 400);
    }

    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user) {
            // Revoke all tokens for this user
            $user->tokens()->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }
}
