<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public $productService;

    public function __construct(
        \App\Services\Product\Service $productService,
    )
    {
        $this->productService = $productService;
    }

    public function index(Request $request, $category) {
        $allCategories = Category::all();

        $category = $allCategories->where('slug', $category)->first();
        $mainCategories = $allCategories->whereNull('parent_id')->all();

        $products = $this->productService->getProducts($request, $category);

        $minMaxDimensions = Product::getMaxMinDimensions($category);
        $productsCount = $products->get()->count();
        $minMaxPrice = Product::getMaxMinPrice($category);
        $allColors = Product::getColors($category);

        $paginatedProducts = $products->paginate(24)->withQueryString();

        if ($category->parent_id == null) {
            $subCategories = $category->children;
        } else {
            $subCategories = null;
        }

        return view('shop.index', compact('paginatedProducts', 'productsCount', 'minMaxPrice', 'minMaxDimensions', 'allColors', 'category', 'subCategories', 'mainCategories'));
    }

    public function show($category, $slug) {
        $allCategories = Category::all();

        $category = $allCategories->where('slug', $category)->first();
        $mainCategories = $allCategories->whereNull('parent_id')->all();

        $product = $this->productService->getProduct($slug);

        if ($category->children->count() > 0) {
            $subcategory = $product->category;
        } else {
            $subcategory = $category;
            $category = $category->parent;
        }

        return view('shop.show', compact('category', 'mainCategories', 'product', 'subcategory'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($product)
    {
        //
    }

    public function update(Request $request, $product)
    {
        //
    }

    public function destroy($product)
    {
        //
    }
}
