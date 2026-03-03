<?php

namespace App\Http\Controllers\API\AUTH;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AUTH\ForgetPasswordRequest;
use App\Http\Requests\API\AUTH\ResendOtpRequest;
use App\Http\Requests\API\AUTH\ResetPasswordRequest;
use App\Http\Requests\API\AUTH\VerifyForgetPasswordRequest;
use App\Services\ForgetPasswordService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    use ApiResponse;

    protected $forgetPasswordService;

    public function __construct(ForgetPasswordService $forgetPasswordService)
    {
        $this->forgetPasswordService = $forgetPasswordService;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $result = $this->forgetPasswordService->sendOtp($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 200);
    }

    public function verifyOtp(VerifyForgetPasswordRequest $request)
    {
        $result = $this->forgetPasswordService->verifyOtp($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->forgetPasswordService->resetPassword($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 200);
    }
    public function resendOtp(ResendOtpRequest $request)
    {
        $result = $this->forgetPasswordService->resendOtp($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message'], 200);
    }
}
