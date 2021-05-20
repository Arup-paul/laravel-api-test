<?php


namespace Tests\Feature\Http\Controller\Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan("passport:install");
    }

    /**
     * @test
     */

    public function can_authenticated(){
       $response = $this->json('POST','/auth/token',[
         'email' => $this->create('User',[],false)->email,
         'password' => 'secret',
       ]);
       $response->assertStatus(200)
                  ->assertJsonStructure(['token']);
    }
}
