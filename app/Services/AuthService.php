<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    use ApiResponse;

    public function register(array $data)
    {
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'avatar' => $data['avatar'] ?? null,
            'is_active' => false,
        ]);

        if ($user) {
            $code = random_int(100000, 999999);
            $codeHash = Hash::make((string) $code);
            $expiresAt = now()->addMinutes(10);

            // إرسال OTP على الإيميل في الخلفية (Queue)
            Mail::to($user->email)->queue(new OtpMail($code, $user->full_name));

            Otp::create([
                'phone' => $user->phone,
                'email' => $user->email,
                'code' => $codeHash,
                'type' => 'register',
                'user_id' => $user->id,
                'expires_at' => $expiresAt,
            ]);
        }

        return [
            'status' => true,
            'message' => __('messages.user_registered_successfully'),
            'data' => [
                'user' => new UserResource($user),
            ],
        ];
    }

    public function verifyOtp(array $data): array
    {
        // نجيب المستخدم بالإيميل الأول
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => __('messages.otp_invalid'),
                'data' => [],
            ];
        }

        // لو الحساب متحقق منه بالفعل
        if ($user->email_verified_at) {
            return [
                'status' => false,
                'message' => __('messages.account_already_verified'),
                'data' => [],
            ];
        }

        // نجيب الـ OTP بالرقم بتاع المستخدم
        $otp = Otp::where('email', $user->email)
            ->where('type', 'register')
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp || !Hash::check($data['code'], $otp->code)) {
            return [
                'status' => false,
                'message' => __('messages.otp_invalid'),
                'data' => [],
            ];
        }

        $otp->update(['verified_at' => now()]);

        $user->update([
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return [
            'status' => true,
            'message' => __('messages.otp_verified_successfully'),
            'data' => [],
        ];
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'status' => false,
                'message' => __('messages.invalid_credentials'),
                'data' => [],
            ];
        }

        if (!$user->is_active) {
            return [
                'status' => false,
                'message' => __('messages.account_not_verified'),
                'data' => [],
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'status' => true,
            'message' => __('messages.user_logged_in_successfully'),
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ],
        ];
    }

    public function logout($user): array
    {
        $user->currentAccessToken()->delete();

        return [
            'status' => true,
            'message' => __('messages.user_logged_out_successfully'),
            'data' => [],
        ];
    }
}
