<?php

namespace Tests;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function create(string $model, array $attributes = []){
        $model = "App\\Models\\$model";
        $product = $model::factory()->create($attributes);
        return new ProductResource($product);
    }
}
