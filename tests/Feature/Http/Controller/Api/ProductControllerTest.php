<?php

namespace Tests\Feature\Http\Controller\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_a_product()
    {
        $response =  $this->json('POST','/api/products',[

        ]);

        $response->assertStatus(201);
    }
}
