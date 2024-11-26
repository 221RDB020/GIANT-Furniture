<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Product;

class Service
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProduct($slug) {
        return $this->model->where('slug', $slug)->first();
    }

    public function getProducts($request, $category = null) {
        if(is_null($category)) {
            $categories = Category::all();
            $categoryIds = $categories->pluck('id')->toArray();
            return $this->model
                ->filter($request->all())
                ->whereIn('category_id', $categoryIds);
        }

        if ($category->children->count() > 0) {
            $categoryIds = $category->children->pluck('id')->toArray();
            return $this->model
                ->filter($request->all())
                ->whereIn('category_id', $categoryIds);
        }

        return $products = $this->model
            ->filter($request->all())
            ->where('category_id', $category->id);
    }
}