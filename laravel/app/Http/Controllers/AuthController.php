<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Helpers\HandleErrorHelper;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signup(SignupRequest $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {

            $data = $request->validated();
            $res = $this->authService->signup($data);

            return response()->json([
                'user' => $res->user,
                'message' => $res->message,
            ], $res->status);
        }, request());
    }

    public function signin(SigninRequest $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {

            $data = $request->validated();
            $res = $this->authService->signin($data);

            return response()->json([
                'user' => $res->user,
                'token' => $res->token,
            ], $res->status);
        }, request());
    }

    public function profile(Request $request)
    {
        $profile = $request->user();

        return response()->json([
            'user' => $profile,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User Logout Success',
        ], 200);
    }
}
