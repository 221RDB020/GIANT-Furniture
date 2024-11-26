<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $allCategories = Category::all();
        $mainCategories = $allCategories->whereNull('parent_id')->all();
        $orders = auth()->user()->orders()->with('products')->latest()->get();

        return view('order.index', compact('mainCategories', 'orders'));
    }

    public function show($order) {
        $order = Order::findOrFail($order)
        ->load('products');

        return view('order.show', compact('order'));
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
