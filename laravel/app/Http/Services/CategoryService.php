<?php

namespace App\Http\Services;

use App\Jobs\RedisClient;
use App\Models\Category;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Redis;

class CategoryService
{
    protected $productService;

    public function __construct()
    {
        $this->productService = fn() => app()->make(ProductService::class);
    }

    public function create($data)
    {
        $this->categoryCheck($data);
        $category = Category::create($data);

        RedisClient::dispatch('category_created', $category);
        return $category;
    }
    public function list()
    {
        $categories = Category::all();
        return $categories;
    }
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new ErrorException('Category not found', 404);
        }

        $products = ($this->productService)()->categoryProducts($category->id);
        return $products;
    }
    public function edit($id, $data)
    {
        $category = $this->show($id);
        $category->title = $data->title;

        $category->save();
        return $category;
    }

    public function delete($id)
    {
        $category = $this->show($id);
        $category->delete();

        return 'Success';
    }

    public function categoryUpdate($id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new ErrorException('Category not found', 404);
        }

        $category->product_count += 1;
        $category->save();

        return true;
    }

    private function categoryCheck($title)
    {
        $category = Category::where("title", $title)->first();
        if ($category) {
            throw new ErrorException('Category already created', 400);
        }

        return true;
    }
}