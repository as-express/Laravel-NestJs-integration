<?php

namespace App\Http\Controllers;

use App\Helpers\HandleErrorHelper;
use App\Http\Requests\basket\BasketRequest;
use App\Http\Requests\product\CreateProductRequest;
use App\Http\Requests\product\EditProductRequest;
use Illuminate\Http\Request;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(CreateProductRequest $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {
            $data = $request->validated();
            $product = $this->productService->create($data);

            return response()->json($product, 201);
        }, request());
    }

    public function list()
    {
        return HandleErrorHelper::handle(function () {
            $products = $this->productService->list();
            return response()->json($products, 200);
        }, request());
    }

    public function show($id)
    {
        return HandleErrorHelper::handle(function () use ($id) {
            $product = $this->productService->show($id);
            return response()->json($product, 200);
        }, request());
    }

    public function addToBasket($id, Request $request, BasketRequest $basketRequest)
    {
        return HandleErrorHelper::handle(function () use ($id, $request, $basketRequest) {
            $data = $basketRequest->validated();
            $id = intval($id);
            $product = $this->productService->addToBasket
            ($id, $data['quantity'], $request->user()->id);

            return response()->json($product, 200);
        }, request());
    }

    public function edit($id, EditProductRequest $request)
    {
        return HandleErrorHelper::handle(function () use ($id, $request) {
            $data = $request->validated();
            $product = $this->productService->edit($id, $data);

            return response()->json($product, 200);
        }, request());
    }

    public function delete($id)
    {
        return HandleErrorHelper::handle(function () use ($id) {
            $product = $this->productService->delete($id);
            return response()->json($product, 200);
        }, request());
    }
}
