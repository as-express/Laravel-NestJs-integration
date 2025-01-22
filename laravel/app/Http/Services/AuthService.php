<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;
use App\Http\Resources\UserResource;
use App\Jobs\BasketCreateJob;
use App\Jobs\RedisClient;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Queue\Jobs\RedisJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AuthService
{
    protected $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function signup($data)
    {
        $this->checkUser($data['email']);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        // SendEmailJob::dispatch($user);
        BasketCreateJob::dispatch($user);

        RedisClient::dispatch('user_created', $user);
        return (object) [
            'user' => $user,
            'message' => 'User Created Success',
            'status' => 201,
        ];
    }

    public function signin($data)
    {
        if (
            !Auth::attempt([
                'email' => $data['email'],
                'password' => $data['password'],
            ])
        ) {
            throw new ErrorException('User with this credentials not defined', 404);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return (object) [
            'user' => $user,
            'token' => $token,
            'status' => 200,
        ];
    }

    public function profile($user)
    {
        return (object) [
            'user' => $user,
            'status' => 200,
        ];
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();

        return (object) [
            'message' => 'User Logout Success',
            'status' => 200,
        ];
    }

    private function checkUser($email)
    {
        $isOldUser = User::where('email', $email)->first();
        if ($isOldUser) {
            throw new ErrorException('User with this email already exist', 400);
        }

        return true;
    }
}
