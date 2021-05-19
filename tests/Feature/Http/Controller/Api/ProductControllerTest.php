<?php

namespace Tests\Feature\Http\Controller\Api;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_create_a_product()
    {
        $faker  = Factory::create();
        $response =  $this->json('POST','/api/products',[
          'name'  => $name = $faker->company,
          'slug' => Str::slug($name),
          'price' => $price = random_int(10,100)
        ]);
        Log::info(1,[$response->getContent()]);

        $response->assertJsonStructure([
            'id','name','slug','price','created_at'
        ])->assertJson([
            'name' => $name,
            'slug'=> Str::slug($name),
            'price' => $price
        ])->assertStatus(201);

        $this->assertDatabaseHas('products',[
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => $price
        ]);
    }
    /**
     * @test
     */

    public function will_fail_with_a_404_if_product_is_not_found(){
        $response = $this->json("GET","api/products/-1");
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_return_a_product(){
         $product = $this->create("Product");

         $response = $this->json("GET","api/products/$product->id");

         $response->assertStatus(200)
                  ->assertExactJson([
                      'id' => $product->id,
                      'name' => $product->name,
                      'price'=> (double)$product->price,
                      'slug' => $product->slug,
                      'created_at' => (string)$product->created_at
                  ]);
    }

    /**
     * @test
     */

    public function will_fail_with_a_404_if_product_we_want_to_update_is_not_found(){
        $response = $this->json("PUT","api/products/-1");
        $response->assertStatus(404);
    }

    /**
     * @test
     */

    public function can_update_a_product(){
        $product = $this->create('Product');

        $response = $this->json("PUT","api/products/$product->id",[
            "name" => $product->name.'-updated',
            "slug" => Str::slug($product->name)."-updated",
            "price" =>(double) $product->price + 2,
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $product->id,
                "name" => $product->name.'-updated',
                "slug" => Str::slug($product->name)."-updated",
                "price" =>(double) $product->price + 2,
                "created_at" => (string) $product->created_at
            ]);
        $this->assertDatabaseHas('products',[
            'id' => $product->id,
            "name" => $product->name.'-updated',
            "slug" => Str::slug($product->name)."-updated",
            "price" =>(double) $product->price + 2,
            "created_at" => (string) $product->created_at
        ]);
    }
}

