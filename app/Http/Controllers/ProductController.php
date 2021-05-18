<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(Request $request){

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price
        ]);
        return response()->json($product,201);
    }

}
