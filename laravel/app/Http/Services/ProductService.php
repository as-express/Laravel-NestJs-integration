<?php

namespace App\Http\Services;
use App\Jobs\RedisClient;
use App\Models\Product;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Redis;

class ProductService
{
    protected $categoryService;
    protected $basketService;

    public function __construct()
    {
        $this->categoryService = fn() => app()->make(CategoryService::class);
        $this->basketService = fn() => app()->make(BasketService::class);
    }

    public function create($data)
    {
        ($this->categoryService)()->categoryUpdate($data['category_id']);
        $product = Product::create($data);

        RedisClient::dispatch('product_created', $product);
        return $product;
    }

    public function list()
    {
        $category = Product::all();
        return $category;
    }

    public function show($id)
    {
        return $this->checkProduct($id);
    }

    public function addToBasket($id, $quantity, $user)
    {
        $product = $this->show($id);
        $price = $product->price * $quantity;

        ($this->basketService)()->updateBasket
        ($id, $quantity, $price, $user);

        return 'Product added to basket Success';

    }
    public function edit($id, $data)
    {
        $product = $this->checkProduct($id);
        $product->update($data);

        $product->save();
        return $product;
    }
    public function delete($id)
    {
        $product = $this->checkProduct($id);
        $product->delete();

        return 'Success';
    }

    public function categoryProducts($id)
    {
        $products = Product::where('category_id', $id)->get();
        return $products;
    }
    private function checkProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            throw new ErrorException('Product not found', 404);
        }

        return $product;
    }
}
