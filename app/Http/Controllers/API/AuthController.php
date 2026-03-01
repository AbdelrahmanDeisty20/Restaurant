<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AUTH\EmailVerifiedRequest;
use App\Http\Requests\API\AUTH\LoginRequest;
use App\Http\Requests\API\AUTH\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 200);
    }

    public function emailVerified(EmailVerifiedRequest $request)
    {
        $result = $this->authService->verifyOtp($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 200);
    }
}
