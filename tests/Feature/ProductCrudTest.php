<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{

    private $admin;
    use RefreshDatabase;
    function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }
    public function test_admin_can_store_new_product()
    {
        // $admin = User::factory()->create(['is_admin' => 1]);
        $response = $this->actingAs($this->admin)->post('/products', [
            'name' => 'Orange',
            'type' => 'Fruit',
            'price' => 3.44
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/products');
        $this->assertCount(1, Product::all());
        $this->assertDatabaseHas('products', ['name' => 'Orange', 'type' => 'Fruit', 'price' => 3.44]);
    }
    public function test_admin_can_see_edit_product_page()
    {
        // $admin = User::factory()->create(['is_admin' => 1]);
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->get('products/' . $product->id . '/edit');
        $response->assertStatus(200);
        $response->assertSee($product->type);
    }
    function test_admin_can_update_product()
    {
        // $admin = User::factory()->create(['is_admin' => 1]);
        Product::factory()->create();
        $this->assertCount(1, Product::all());
        $product = Product::first();

        $response = $this->actingAs($this->admin)->put('products/' . $product->id, [
            'name' => 'Updated Product',
            'type' => 'Drink',
            'price' => 2.55
        ]);
        $response->assertSessionHasNoErrors();

        $response->assertRedirect('/products');
        $this->assertEquals('Updated Product', Product::first()->name);
        $this->assertEquals('Drink', Product::first()->type);
        $this->assertEquals(2.55, Product::first()->price);
    }
    function test_admin_can_delete_product()
    {
        $product = Product::factory()->create();
        $this->assertEquals(1, Product::count());
        $response = $this->actingAs($this->admin)->delete('products/' . $product->id);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertEquals(0, Product::count());
        // $this
    }
}
