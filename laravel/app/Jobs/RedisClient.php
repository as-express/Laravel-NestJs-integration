<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Redis;
use Log;

class RedisClient implements ShouldQueue
{
    use Queueable;

    protected $channel;
    protected $message;


    /**
     * Create a new job instance.
     */
    public function __construct(
        $channel,
        $message
    ) {
        $this->channel = $channel;
        $this->message = $message;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Redis::publish($this->channel, json_encode($this->message));

    }
}
