<?php

namespace Tests\Unit;

use App\Http\Controllers\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
		public function testProductList() {
			$product = new Product('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');

			$return = $product->list();

			$this->assertTrue(count($return) > 0);
			$this->assertArrayHasKey('id', $return[0]);
			$this->assertTrue(!array_key_exists('vendor', $return[0]));
			$this->assertInternalType('array', $return[0]['tags']);
		}

		public function testTogglePreOrder() {
			$product = new Product('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');

			$return = $product->toggle_pre_order(9635274770);
			$this->assertFalse(strpos($return, 'Pre Order'));

			$return = $product->toggle_pre_order(9635272082);
			$this->assertTrue(is_numeric(strpos($return, 'Pre Order')));
		}
}
