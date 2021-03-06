<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index(){
        return new ProductCollection(Product::paginate(5));
    }


    public function store(Request $request){

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price
        ]);
        return response()->json(new ProductResource($product),201);
    }

    public function show(int $id){
        $product = Product::findOrfail($id);

        return response()->json(new ProductResource($product));
    }

    public function update(Request $request,$id){
        $product = Product::findOrfail($id);
        $product->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name),
            "price" => $request->price

        ]);
        return response()->json(new ProductResource($product));


    }

    public function destroy($id){
        $product = Product::findOrfail($id);
        $product->delete();

        return response()->json(null,204);


    }

}
