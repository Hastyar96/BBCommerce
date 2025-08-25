<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Language;
use App\Models\CountryCode;

class ApiAuthController extends Controller
{
    /* --------------------------------------------------------------------------
     | Registration
     -------------------------------------------------------------------------- */

    /**
     * Register a new user and send OTP via WhatsApp.
     */
    public function register(Request $request)
    {
        try {
            // 1. Validate input
            $validator = $this->validateRegistration($request);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            // 2. Format phone number
            $phone = $this->formatPhoneNumber($request->cuntry_code, $request->phone);

            // 3. Rate limit OTP sending
            if (!$this->checkOtpRateLimit($phone)) {
                return response()->json([
                    'message' => 'Please wait 60 seconds before requesting another OTP.'
                ], 429);
            }

            // 4. Generate OTP
            $otp = random_int(100000, 999999);

            // 5. Create user
            $user = $this->createUser($request, $otp, $phone);

            //6. Send OTP via OTPIQ WhatsApp API
            $response = $this->sendOtp($phone, $otp);
            if (!$response->successful()) {
                $user->delete(); // rollback
                return response()->json([
                    'message' => 'Failed to send OTP via WhatsApp.',
                    'error' => $response->json(),
                ], 500);
            }

            // 7. Generate token
            $token = $user->createToken('API Token')->plainTextToken;
            $language = Language::find($user->language_id);

            return response()->json([
                'message' => 'Registration successful! Please check your WhatsApp for the OTP.',
                'user' => $user,
                'language' => $language,
                'token' => $token,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during registration.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function validateRegistration(Request $request)
    {
        return Validator::make($request->all(), [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'cuntry_code'   => ['required', 'string', 'regex:/^[0-9]{1,4}$/'],
            'phone'         => ['required', 'string', 'unique:users,phone', 'regex:/^[0-9]{6,10}$/'],
            'password'      => 'required|string|min:8|confirmed',
            'language_id'   => 'required|exists:languages,id',
        ], [
            'cuntry_code.regex' => 'The country code must be 1 to 4 digits. Example: 964',
            'phone.regex'       => 'The phone number must be 6 to 10 digits.',
        ]);
    }

    protected function createUser(Request $request, $otp, $phone)
    {
        return User::create([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'phone'            => $phone,
            'password'         => Hash::make($request->password),
            'role_id'          => 1,
            'verify_code'      => Hash::make($otp),
            'language_id'      => $request->language_id,
            'cuntry_code'      => $request->cuntry_code,
            'otp_expires_at'   => now()->addMinutes(10),
        ]);
    }

    protected function sendOtp($phone, $otp)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OTPIQ_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post(env('OTPIQ_BASE_URL', 'https://api.otpiq.com/api/') . 'sms', [
            'phoneNumber'       => $phone,
            'smsType'           => 'verification',
            'verificationCode'  => (string) $otp,
            'provider'          => 'whatsapp',
        ]);
    }

    protected function formatPhoneNumber($countryCode, $phone)
    {
         $phone = ltrim($phone, '0');
        return $countryCode . $phone;
    }

    protected function checkOtpRateLimit($phone)
    {
        return Cache::add("otp_limit_$phone", true, 60); // 60 seconds
    }

    /* --------------------------------------------------------------------------
     | OTP Verification
     -------------------------------------------------------------------------- */

   public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'otp'         => ['required', 'string'],
            ]);

            $fullPhone =Auth::user()->phone;


            if (!Auth::user()->otp_expires_at || Auth::user()->otp_expires_at < now()) {
                return response()->json(['message' => 'OTP expired'], 400);
            }

            if (Hash::check($request->otp,Auth::user()->verify_code)) {
                Auth::user()->update([
                    'verify_code'      => null,
                    'phone_verified_at'=> now(),
                    'is_verify'        => 1,
                    'otp_expires_at'   => null,
                ]);

                return response()->json([
                    'message' => 'OTP verified',
                    'user'    => Auth::user(),
                ]);
            }

            return response()->json(['message' => 'Invalid OTP'], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during OTP verification.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    /*Resend OTP*/
    public function resendOtp()
    {
       $fullPhone = Auth::user()->phone;


        // Block resend if exceeded limit
        $key = 'otp_send_count_' . $fullPhone;
        $maxAttempts = 5;
        $decayMinutes = 60;

        if (cache()->has($key) && cache()->get($key) >= $maxAttempts) {
            return response()->json([
                'message' => 'Too many OTP requests. Please try again later.'
            ], 429);
        }



        // Check if already verified
        if (Auth::user()->phone_verified_at) {
            return response()->json(['message' => 'Phone number already verified.'], 400);
        }

        // Rate limit resend: max once per 60 seconds
        if (!$this->checkOtpRateLimit($fullPhone)) {
            return response()->json(['message' => 'Please wait before requesting another OTP.'], 429);
        }

        // Generate and send OTP
        $otp =random_int(100000, 999999);
        Auth::user()->update([
            'verify_code'    => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->sendOtp($fullPhone, $otp);

        if (!$response->successful()) {
            $fallbackResponse = $this->sendOtpFallback($fullPhone, $otp);
            if (!$fallbackResponse->successful()) {
                return response()->json([
                    'message' => 'Failed to send OTP via both primary and fallback providers.',
                ], 500);
            }
        }

        // Increment resend count
        cache()->increment($key);
        cache()->put($key, cache()->get($key, 0), now()->addMinutes($decayMinutes));

        return response()->json(['message' => 'OTP resent successfully.']);
    }



    /* --------------------------------------------------------------------------
     | Login / Logout
     -------------------------------------------------------------------------- */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'    => 'required|string|exists:users,phone',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;
        $language = Language::find($user->language_id);

        return response()->json([
            'message'  => 'Login successful!',
            'user'     => $user,
            'language' => $language,
            'token'    => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

    /* --------------------------------------------------------------------------
     | Country Code (for Phone Registration)
     -------------------------------------------------------------------------- */

    public function countries()
    {
        $countries = CountryCode::select('id', 'country_name', 'iso_code', 'dialing_code', 'flag_path')
            ->get()
            ->map(function ($country) {
                return [
                    'id'             => $country->id,
                    'country_name'   => $country->country_name,
                    'iso_code'       => $country->iso_code,
                    'dialing_code'   => '+' . ltrim($country->dialing_code, '0'),
                    'flag_path'      => asset($country->flag_path),
                    'flag_emoji'     => $country->flag_emoji,
                ];
            });

        $ip = $this->getClientIp();
        $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,countryCode");

        $default = null;
        if ($response->ok() && $response['status'] === 'success') {
            $default = $countries->firstWhere('iso_code', $response['countryCode']);
        }

        return response()->json([
            'default_selected_country' => $default,
            'countries'                => $countries,
        ]);
    }

    /* --------------------------------------------------------------------------
     | Helpers
     -------------------------------------------------------------------------- */

    private function getClientIp(): string
    {
        return explode(',', request()->header('X-Forwarded-For')
            ?? $_SERVER['HTTP_CLIENT_IP']
            ?? $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['HTTP_X_FORWARDED']
            ?? $_SERVER['HTTP_FORWARDED_FOR']
            ?? $_SERVER['HTTP_FORWARDED']
            ?? $_SERVER['REMOTE_ADDR']
            ?? 'UNKNOWN')[0];
    }
}
