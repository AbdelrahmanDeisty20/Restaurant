<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Str;

class AuthService
{
    use ApiResponse;

    public function register(array $data)
    {
        $avatarName = null;
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $path = public_path('storage/users/avatars');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $avatarName = time() . '.' . $data['avatar']->getClientOriginalExtension();
            $data['avatar']->move($path, $avatarName);
        }

        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'avatar' => $avatarName,
            'is_active' => false,
        ]);

        if ($user) {
            $code = random_int(100000, 999999);
            $codeHash = Hash::make((string) $code);
            $expiresAt = now()->addMinutes(10);

            // إرسال OTP على الإيميل في الخلفية (Queue)
            Mail::to($user->email)->locale(app()->getLocale())->queue(new OtpMail($code, $user->full_name, 'register'));

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

    public function profile($user)
    {
        return [
            'status' => true,
            'message' => __('messages.user_profile_successfully'),
            'data' => [
                'user' => new UserResource($user),
            ],
        ];
    }

    public function updateProfile($user, array $data): array
    {
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $path = public_path('storage/users/avatars');

            // مسح الصورة القديمة إذا وجدت
            if ($user->avatar && file_exists($path . '/' . $user->avatar)) {
                unlink($path . '/' . $user->avatar);
            }

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $avatarName = time() . '.' . $data['avatar']->getClientOriginalExtension();
            $data['avatar']->move($path, $avatarName);
            $data['avatar'] = $avatarName;
        }

        $user->update($data);

        return [
            'status' => true,
            'message' => __('messages.user_profile_successfully'),
            'data' => [
                'user' => new UserResource($user),
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

    public function resendOtp(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => __('messages.user_not_found'),
                'data' => [],
            ];
        }

        if ($user->email_verified_at) {
            return [
                'status' => false,
                'message' => __('messages.account_already_verified'),
                'data' => [],
            ];
        }

        $code = random_int(100000, 999999);
        $codeHash = Hash::make((string) $code);
        $expiresAt = now()->addMinutes(10);

        // إرسال OTP على الإيميل في الخلفية (Queue)
        Mail::to($user->email)->queue(new OtpMail($code, $user->full_name, 'resend'));

        Otp::create([
            'phone' => $user->phone,
            'email' => $user->email,
            'code' => $codeHash,
            'type' => 'register',
            'user_id' => $user->id,
            'expires_at' => $expiresAt,
        ]);

        return [
            'status' => true,
            'message' => __('messages.otp_sent_successfully'),
            'data' => [],
        ];
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $frontendUrl = rtrim(env('FRONTEND_URL', 'http://localhost:5173'), '/');
        $callbackPath = '/auth/google-callback';

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => __('messages.social_login_failed'),
                'data' => [
                    'redirect_url' => $frontendUrl . $callbackPath . '?error=' . urlencode(__('messages.social_login_failed')),
                ],
            ];
        }

        $existingUser = User::where('email', $socialUser->email)->first();

        if ($existingUser) {
            $token = $existingUser->createToken('auth_token')->plainTextToken;
            $userResource = new UserResource($existingUser);
        } else {
            $newUser = User::create([
                'full_name'         => $socialUser->name,
                'email'             => $socialUser->email,
                'password'          => $socialUser->id,
                'avatar'            => $socialUser->avatar,
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);
            $token = $newUser->createToken('auth_token')->plainTextToken;
            $userResource = new UserResource($newUser);
        }

        $query = http_build_query([
            'token'       => $token,
            'id'          => $userResource->id,
            'full_name'   => $userResource->full_name,
            'email'       => $userResource->email,
            'avatar_path' => $userResource->avatar_path ?? '',
        ]);

        return [
            'status'  => true,
            'message' => __('messages.user_logged_in_successfully'),
            'data'    => [
                'redirect_url' => $frontendUrl . $callbackPath . '?' . $query,
            ],
        ];
    }
}
