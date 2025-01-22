<?php

namespace App\Http\Controllers;
use App\Helpers\HandleErrorHelper;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function createOrder(Request $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {
            $userId = $request->user()->id;
            $address = $request->address;
            $order = $this->orderService->createOrder($userId, $address);

            return response()->json($order);
        }, request());
    }
}
