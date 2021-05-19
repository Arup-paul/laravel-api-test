<?php

namespace Tests;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function create(string $model, array $attributes = [],$resource = true){
        $modelClass = "App\\Models\\$model";
        $resourceModel = $modelClass::factory()->create($attributes);
        $resourceClass = "App\\Http\\Resources\\$model".'Resource';
        if(!$resource){
            return $resourceModel;
        }


        return new $resourceClass($resourceModel);
    }
}
