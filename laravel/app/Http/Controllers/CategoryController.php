<?php

namespace App\Http\Controllers;

use App\Helpers\HandleErrorHelper;
use App\Http\Requests\category\CategoryRequest;
use App\Http\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CategoryRequest $request)
    {
        return HandleErrorHelper::handle(function () use ($request) {

            $data = $request->validated();
            $res = $this->categoryService->create($data);

            return response()->json($res, 201);
        }, request());
    }
    public function list()
    {
        $categories = $this->categoryService->list();
        return response()->json($categories, 200);
    }

    public function show($id)
    {
        return HandleErrorHelper::handle(function () use ($id) {
            $category = $this->categoryService->show($id);
            return response()->json($category, 200);
        }, request());
    }

    public function edit($id, CategoryRequest $request)
    {
        return HandleErrorHelper::handle(function () use ($id, $request) {

            $category = $this->categoryService->edit($id, $request);
            return response()->json($category, 200);
        }, request());
    }

    public function delete($id)
    {
        return HandleErrorHelper::handle(function () use ($id) {
            $category = $this->categoryService->delete($id);
            return response()->json($category, 200);
        }, request());
    }
}
