<?php

namespace Tests\Unit;

use App\Cart;
use App\Convert;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_cart_contents()
    {
        $cart = new  Cart(['Apple', 'Dell']);
        $this->assertTrue($cart->has('Apple'));
        $this->assertTrue($cart->has('Dell'));
    }
    public function test_take_one_from_cart()
    {
        $cart = new Cart(['Apple']);
        $this->assertEquals('Apple', $cart->tokenOne());
        $this->assertNull($cart->tokenOne());
    }

    public function test_convert_price()
    {
        $convert = new Convert(100);
        $this->assertEquals(113, $convert->priceInUsd());
        $this->assertEquals(83, $convert->priceInGbp());
        $this->assertEquals(144, $convert->priceInCad());
    }
}
