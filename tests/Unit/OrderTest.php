<?php

namespace Tests\Unit;

use App\Http\Controllers\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOrderList()
    {
			$order = new Order('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');

			$return = $order->list(1);

			$this->assertTrue(count($return) > 0);
			$this->assertArrayHasKey('id', $return[0]);
			$this->assertTrue(!array_key_exists('vendor', $return[0]));

    }
}
