<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Redis;

class RedisService
{
    public function sendMessage(string $channel, $message)
    {
        Redis::publish($channel, json_encode($message));
    }
}