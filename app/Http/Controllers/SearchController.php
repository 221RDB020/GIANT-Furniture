<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact('results', 'query'));
    }

}
