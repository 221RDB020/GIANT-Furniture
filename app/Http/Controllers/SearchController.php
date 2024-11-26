<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public $productService;

    public function __construct(
        \App\Services\Product\Service $productService,
    )
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $allCategories = Category::all();
        $mainCategories = $allCategories->whereNull('parent_id')->all();

        $query = $request->input('query');

        $products = $this->productService->getProducts($request)
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%");

        $minMaxDimensions = Product::getMaxMinDimensions();
        $productsCount = $products->get()->count();
        $minMaxPrice = Product::getMaxMinPrice();
        $allColors = Product::getColors();

        $paginatedProducts = $products->paginate(24)->withQueryString();

        return view('search.index', compact('paginatedProducts', 'query', 'mainCategories', 'minMaxDimensions', 'productsCount', 'minMaxPrice', 'allColors'));
    }

}
