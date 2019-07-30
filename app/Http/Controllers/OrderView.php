<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Product;
use Illuminate\Http\Request;

class OrderView extends Controller
{
    public function __construct(Request $request)
    {
			$this->middleware('auth');
			$this->request = $request;
			$this->product = new Product('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');
			$this->order = new Order('3f9b2c4bebb6301f603facf45d1cbb7f', '808898e3fc04b4e5f2a58e5051750984', 'transmission-records.myshopify.com');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			$page_count = $this->order->count();

			$page_num = (is_numeric($this->request->input('page')) ?  $this->request->input('page') : 1);
			$order_list = $this->order->list($page_num);

			for ($i = 0; $i < count($order_list); $i++) {
				$order_list[$i]['preorder'] = false;
				for ($j = 0; $j < count($order_list[$i]['line_items']); $j++) {
					if(is_numeric($order_list[$i]['line_items'][$j]['product_id'])) {
						if ($this->product->is_preorder($order_list[$i]['line_items'][$j]['product_id'])) {
							$order_list[$i]['preorder'] = true;
						}
					}
				}
			}

			return view('order/list', [
				'orders' => $order_list,
				'page_count' => $page_count,
			]);
    }

		public function purchase_order() {
			$id_list = $this->request->input('id');

			$order = $this->order->by_id($id_list);
			return view('print/purchase_order', [
				'orders' => $order,
			]);
		}

		public function label() {
			$id_list = $this->request->input('id');

			$order = $this->order->by_id($id_list);


			for ($i = 0; $i < count($order); $i++) {
				$order[$i]['product'] = [];
				$temp = [];

				foreach ($order[$i]['line_items'] as $index => $item) {
					array_push($temp, $item);

					if ((($index+1) % 3) == 0 && $index != 0) {
						array_push($order[$i]['product'], $temp);
						$temp = [];
					}
				}

				if (!empty($temp)) {
					array_push($order[$i]['product'], $temp);
					unset($temp);
				}
			}

			return view('print/label', [
				'orders' => $order,
			]);
		}
}
