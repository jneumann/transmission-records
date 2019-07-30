<html>
	<body>
		@foreach ($orders as $order)
		<div class="order">
			<h2>Purchase Order</h2>
			<div class="customer">
				<h2>Customer Information</h2>
				<div>{{ $order['customer']['first_name'] }} {{ $order['customer']['first_name'] }}</div>
				<div>{{ $order['customer']['email'] }}</div>
			</div>
			<div class="ship_to">
				<h2>Shipping Infomration</h2>
					<div>{{ $order['shipping_address']['name'] }}</div>
					<div>{{ $order['shipping_address']['address1'] }}</div>
					@if ($order['shipping_address']['address2'] !== '')
					<div>{{ $order['shipping_address']['address2'] }}</div>
					@endif
					<div>{{ $order['shipping_address']['city'] }} {{ $order['shipping_address']['province_code'] }}, {{$order['shipping_address']['zip'] }}</div>
			</div>
			<div class="products">
				<table>
					<tr>
						<th>Product Name</th>
						<th>Sku</th>
						<th>Quantity</th>
					</tr>
					@foreach ($order['line_items'] as $product)
						<tr>
							<td>{{ $product['title'] }}</td>
							<td>{{ $product['sku'] }}</td>
							<td>{{ $product['quantity'] }}</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
		@endforeach
		<style>
			h2 {
				text-align: center;
			}
			.customer,
			.ship_to {
				width: 49%;
				float: left;
				margin-bottom: .5in;
			}
			table {
				width: 100%;
			}
			.order {
				width: 7.5in;
				height: 10in;
				margin: .5in;
			}
		</style>
	</body>
</html>
