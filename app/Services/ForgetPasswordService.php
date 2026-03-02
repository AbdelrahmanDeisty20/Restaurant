<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordService
{
    public function sendOtp($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return ['status' => false, 'message' => __('messages.user_not_found'), 'data' => []];
        }

        $code = random_int(100000, 999999);
        $codeHash = Hash::make((string) $code);
        $expiresAt = now()->addMinutes(10);

        // إرسال OTP على الإيميل
        Mail::to($user->email)->queue(new OtpMail($code, $user->full_name, 'reset_password'));

        Otp::create([
            'phone' => $user->phone,
            'email' => $user->email,
            'code' => $codeHash,
            'type' => 'reset_password',
            'user_id' => $user->id,
            'expires_at' => $expiresAt,
        ]);

        return ['status' => true, 'message' => __('messages.otp_sent_successfully'), 'data' => []];
    }

    public function verifyOtp($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return ['status' => false, 'message' => __('messages.user_not_found'), 'data' => []];
        }

        $otp = Otp::where('user_id', $user->id)
            ->where('type', 'reset_password')
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp || !Hash::check($data['otp'], $otp->code)) {
            return ['status' => false, 'message' => __('messages.otp_invalid'), 'data' => []];
        }

        $token = Str::random(60);
        $otp->update([
            'verified_at' => now(),
            'reset_token' => $token,
        ]);

        return [
            'status' => true,
            'message' => __('messages.otp_verified_successfully'),
            'data' => [
                'token' => $token,
            ]
        ];
    }

    public function resetPassword($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return ['status' => false, 'message' => __('messages.user_not_found'), 'data' => []];
        }

        // التأكد من وجود توكن صالح ومتحقق منه لهذا المستخدم
        $otp = Otp::where('user_id', $user->id)
            ->where('type', 'reset_password')
            ->whereNotNull('verified_at')
            ->where('reset_token', $data['token'])
            ->first();

        if (!$otp) {
            return ['status' => false, 'message' => __('messages.invalid_token'), 'data' => []];
        }

        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        // حذف التوكن بعد الاستخدام لزيادة الأمان
        $otp->delete();

        return ['status' => true, 'message' => __('messages.password_reset_successfully'), 'data' => []];
    }
}
