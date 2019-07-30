<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Product extends Shopify
{
	private function tag_to_array(string $tags): array {
		return preg_split('/, /', $tags);
	}

	public function list(int $page = 1): array {
		$this->count();

		$return = [];

		$list = $this->get('/admin/products.json', [
			'fields' => 'tags,id,title,image',
			'limit' => 100,
			'page' => $page
		])['products'];

		for ($i = 0; $i < count($list); $i++){
			$list[$i]['tags'] = $this->tag_to_array($list[$i]['tags']);
		}

		return $list;
	}

	public function count(): int {
		$product_count = $this->get('/admin/products/count.json')['count'];
		return ceil($product_count / 100);
	}

	public function by_title(string $title): array {
		$search = $this->get('/admin/products.json', [
			'fields' => 'tags,id,title,image',
			'title' => urlencode($title),
		])['products'];

		for ($i = 0; $i < count($list); $i++){
			$search[$i]['tags'] = $this->tag_to_array($search[$i]['tags']);
		}

		return $search;
	}

	private function by_id(int $id): array {
		$single = $this->get("/admin/products/$id.json", [
			'fields' => 'tags,id,title,image',
		]);
		if(array_key_exists('product', $single)) {
			$single = $single['product'];
		} else {
			return [];
		}

		$single['tags'] = $this->tag_to_array($single['tags']);

		return $single;
	}

	/*
	 * @param $id Shopify product ID
	 * @param $tag_list 
	 */
	public function update_tags(int $id, string $tag_list): array {
		var_dump(substr($tag_list, 1, -1));
		return $this->put("/admin/products/$id.json", [
			"product" =>  [
				"id" => $id,
				"tags" => $tag_list
			]
		]);
	}

	public function toggle_pre_order(int $id) {
		$product = $this->by_id($id);

		if(in_array("Pre Order", $product['tags'])) {
			$key = array_search("Pre Order", $product['tags']);
			unset($product['tags'][$key]);
		} else {
			array_push($product['tags'], "Pre Order");
		}

		$tag_string = "";
		foreach($product['tags'] as $tag) {
			$tag_string .= "," . $tag;
		}

		str_replace(",,", ",", $tag_string);

		return $this->update_tags($id, $tag_string);
	}

	public function is_preorder(int $id): bool {
		$product = $this->by_id($id);

		if(!array_key_exists('tags', $product)) {
			return false;
		}

		return in_array("Pre Order", $product['tags']);
	}
}
