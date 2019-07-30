<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Order extends Shopify
{
	public function list($page): array {
		$return = [];

		$order_list = $this->get('/admin/orders.json', [
			'fields' => 'id,name,line_items,total_price',
			'limit' => 25,
			'status' => 'open',
			'page' => $page
		])['orders'];

		foreach ($order_list as $order) {
			array_push($return, $order);
		}

		return $return;
	}

	public function by_id($id): array {
		return $this->get('/admin/orders.json', [
			'ids' => $id,
			'fields' => 'id,name,line_items,total_price,shipping_address,customer',
			'limit' => 250,
			'status' => 'any',
		])['orders'];
	}

	public function count(): int {
		$order_count = $this->get('/admin/orders/count.json', [
			'status' => 'open',
		])['count'];
		return ceil($order_count / 25);
	}
}
