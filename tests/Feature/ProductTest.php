<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    private $product;
    public function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_products_route_return_ok()
    {
        $response = $this->get('/products');
        $response->assertSee('Products');
        $response->assertStatus(200);
    }
    function test_product_has_name()
    {
        $this->assertNotEmpty($this->product->name);
    }
    function test_products_are_not_empty()
    {
        $response = $this->get('/products');
        $response->assertDontSee('No Products');
    }
    function test_auth_user_can_see_the_buy_button()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products');

        $response->assertSee('Buy Product');
    }
    function test_unauth_user_cannot_see_the_buy_button()
    {
        $response = $this->get('/products');
        $response->assertDontSee('Buy Product');
    }
    function test_auth_admin_user_can_access_create_link()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $response = $this->actingAs($admin)->get('/products');
        $response->assertSee('Create');
    }
    function test_unauth_user_cannot_see_create_link()
    {
        $response = $this->get('/products');
        $response->assertDontSee('Create');
    }
    function test_auth_admin_user_can_visit_the_products_create_route()
    {
        $admin = User::factory()->create(['is_admin' => 1]);
        $response = $this->actingAs($admin)->get('/products/create');
        $response->assertStatus(200);
    }
    function test_unauth_user_cannot_visit_the_products_create_route()
    {
        $response = $this->get('/products/create');
        $response->assertStatus(403);
    }
}
