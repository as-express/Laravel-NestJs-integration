<?php

namespace App\Http\Controllers;
use App\Helpers\HandleErrorHelper;
use App\Http\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getBasket(Request $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {
            $userId = $request->user()->id;
            $basket = $this->userService->getBasket($userId);

            return response()->json($basket);
        }, request());
    }

    public function getOrders(Request $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {
            $userId = $request->user()->id;
            $orders = $this->userService->getOrders($userId);
            return response()->json($orders);
        }, request());
    }
}
