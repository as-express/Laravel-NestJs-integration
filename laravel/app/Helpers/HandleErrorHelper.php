<?php

namespace App\Helpers;

use App\Exceptions\ErrorException;
use Illuminate\Http\Request;

class HandleErrorHelper
{
    public static function handle(callable $callback, Request $request)
    {
        try {
            return $callback();
        } catch (ErrorException $error) {
            return $error->throw($request);
        }
    }
}
