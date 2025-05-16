<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class OtpController extends Controller
{
    public function sendEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if email already exists and is verified
        $existingUser = User::where('email', $request->email)
                           ->whereNotNull('email_verified_at')
                           ->first();

        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Email already registered'
            ], 400);
        }

        $otp = rand(1000, 9999);
        $email = $request->email;

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Temp User',
                'code' => $otp,
                'email_verified_at' => null,
                'password' => Hash::make('temp@password123'),
            ]
        );
        
        $data = [
            'email' => $email,
            'title' => 'Mail Verification',
            'body' => 'Your OTP is: ' . $otp,
            'otp' => $otp
        ];

        try {
            Mail::to($email)->send(new TestEmail($data));

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'otp' => $otp
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->code != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.'
            ], 400);
        }

        $updatedAt = Carbon::parse($user->updated_at);
        if (now()->diffInSeconds($updatedAt) > 300) { // 5 minutes expiry
            return response()->json([
                'success' => false,
                'message' => 'OTP expired.'
            ], 400);
        }

        // Mark email as verified but don't clear OTP yet (needed for registration)
        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'OTP successfully verified.'
        ]);
    }

    public function sendWhatsappOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phone = $this->formatPhoneNumber($request->phone);
        
        // Check if phone already exists and is verified
        $existingUser = User::where('user_phone', $phone)
                           ->whereNotNull('phone_verified_at')
                           ->first();

        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already registered'
            ], 400);
        }

        $otp = rand(1000, 9999);
        $now = now();

        try {
            // Save OTP and timestamp
            $user = User::updateOrCreate(
                ['user_phone' => $phone],
                [
                    'code' => $otp,
                    'otp_sent_at' => $now,
                    'password' => Hash::make('temp@password123'),
                ]
            );

            // Send OTP
            $this->sendWhatsAppMessage($phone, $otp);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully via WhatsApp'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send WhatsApp OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendSMSOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phone = $this->formatPhoneNumber($request->phone);
        
        // Check if phone already exists and is verified
        $existingUser = User::where('user_phone', $phone)
                           ->whereNotNull('phone_verified_at')
                           ->first();

        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number already registered'
            ], 400);
        }

        $otp = rand(1000, 9999);
        $now = now();

        try {
            // Save OTP and timestamp
            $user = User::updateOrCreate(
                ['user_phone' => $phone],
                [
                    'code' => $otp,
                    'otp_sent_at' => $now,
                    'password' => Hash::make('temp@password123'),
                ]
            );

            // Send OTP via SMS
            $this->sendSMSMessage($phone, $otp);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully via SMS'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send SMS OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|digits:4'
        ]);

        $phone = $this->formatPhoneNumber($request->phone);

        $user = User::where('user_phone', $phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->code != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP.'
            ], 400);
        }

        // Check if OTP expired (5 minutes)
        if ($user->otp_sent_at && now()->diffInSeconds($user->otp_sent_at) > 300) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired.'
            ], 400);
        }

        // Mark verified
        $user->phone_verified_at = now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.'
        ]);
    }

    public function checkPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phone = $this->formatPhoneNumber($request->phone);

        $exists = User::where('user_phone', $phone)
                     ->whereNotNull('phone_verified_at')
                     ->exists();

        return response()->json([
            'success' => true,
            'exists' => $exists
        ]);
    }

    private function formatPhoneNumber($phone)
    {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Add +92 if number starts with 03 and is 11 digits
        if (substr($phone, 0, 2) === '03' && strlen($phone) === 11) {
            $phone = '92' . substr($phone, 1); // replace 0 with 92
        }

        return $phone;
    }
    
    private function sendWhatsAppMessage($to, $otp)
{
    $sid = config('services.twilio.sid');
    $token = config('services.twilio.token');
    $from = config('services.twilio.whatsapp_from');

    $client = new Client($sid, $token);

    $message = "Your verification code is: $otp\n\nDo not share this code with anyone.";

    try {
        $client->messages->create(
            "whatsapp:$to", // Destination number
            [
                'from' => "whatsapp:$from", // From number with whatsapp: prefix
                'body' => $message
            ]
        );
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send WhatsApp OTP',
            'error' => $e->getMessage()
        ], 500);
    }
}


    private function sendSMSMessage($to, $otp)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $token);

        $message = "Your verification code is: $otp\n\nDo not share this code with anyone.";

        $client->messages->create(
            "+$to",
            [
                'from' => $from,
                'body' => $message
            ]
        );
    }
}