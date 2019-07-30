<?php

namespace Tests\Unit;

use App\Http\Controllers\Shopify;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopifyTest extends TestCase
{
		public function testGetThrowsException() {
			$shopify = new Shopify('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');

			$this->assertEmpty($shopify->get('/error.json'));
		}

		public function testGetCanConnectToStore() {
			$shopify = new Shopify('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');

			$this->assertArrayHasKey('shop', $shopify->get('/admin/shop.json'));
		}

		public function testCanHandleTimeout() {
			$shopify = new Shopify('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');
			for ($i = 0; $i < 65; $i++) {
				$this->assertArrayHasKey('shop', $shopify->get('/admin/shop.json'));
			}
		}
}
