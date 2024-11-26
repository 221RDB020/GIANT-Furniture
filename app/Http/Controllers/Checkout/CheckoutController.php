<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Cart\Service;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $cartService;
    public function __construct(Service $service)
    {
        $this->cartService = $service;
    }

    public function index() {
        $allCategories = Category::all();
        $mainCategories = $allCategories->whereNull('parent_id')->all();

        if ($this->cartService->getItemCount() == 0) {
            return redirect()->route('cart.index');
        }

        $cartItems = $this->cartService->getItems();
        $subtotal = 0;
        $total = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $total += $item['price'] * (1-$item['attributes']['discount']) * $item['quantity'];
        }

        $contents = [
            'cartItems' => $cartItems,
            'cartTaxRate' => 0,
            'cartSubtotal' => $subtotal,
            'cartTotal' => $total,
        ];

        if (!auth()->check()) {
            return view('checkout.guest', compact('mainCategories', 'contents'));
        }

        return view('checkout.index', compact('mainCategories', 'contents'));
    }

    public function show() {

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
