<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Category;

class WarehouseController extends Controller
{
    public function index() {
        $mainCategories = Category::whereNull('parent_id')->get();

        return view('warehouse.index', compact('mainCategories'));
    }
}
