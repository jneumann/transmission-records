<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Product;
use Illuminate\Http\Request;

class ProductView extends Controller
{
	public function __construct(Request $request) {
		$this->request = $request;
		$this->product = new Product('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$page_count = 1;

		if ($this->request->input('search') !== null) {
			$product_list = $this->product->by_title($this->request->input('search'));
		} else {
			$page_num = (is_numeric($this->request->input('page')) ?  $this->request->input('page') : 1);
			$product_list = $this->product->list($page_num);
			$page_count = $this->product->count();
		}

		return view('product/list', [
			'products' => $product_list,
			'page_count' => $page_count,
		]);
	}

	public function toggle() {
		$product_id = $this->request->input('id');
		return $this->product->toggle_pre_order($product_id);
	}
}
