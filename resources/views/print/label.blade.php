<html>
	<body>
		<div class="paper">
			@foreach ($orders as $order)
				<div class="label">
				<div class="wrapper">
						<div style="max-width: 45%; float: left">{{ $order['shipping_address']['name'] }}</div>
						<div style="max-width: 45%; float: right">Order: {{ $order['name'] }}</div>
            <div style="clear:both; width: 0; height: 0;"></div>
						<div>{{ $order['shipping_address']['address1'] }}</div>
						@if ($order['shipping_address']['address2'] !== '')
						<div>{{ $order['shipping_address']['address2'] }}</div>
						@endif
						<div>{{ $order['shipping_address']['province_code'] }}</div>
						<div>{{ $order['shipping_address']['country'] }}</div>
						<div>{{ $order['shipping_address']['zip'] }}</div>
						<br />
						@php
							$index = 0;
						@endphp
						@foreach ($order['product'] as $product)
							@if ($index != 0)
							</div>
							<div class="label">
							<div class="wrapper">
							@endif
							<div class="product">
								@foreach ($product as $prod)
									<div>
										{{ $prod['quantity'] }} - {{ $prod['title'] }}
									</div>
								@endforeach
							</div>
							@php
								$index += 1;
							@endphp
							<br />
							<div style="text-align: center">www.transmissionrecords.co.uk</div>
							</div>
						@endforeach
				</div>
			@endforeach
		</div>
		<style>
			@page {
				size: auto;
				margin: 0;
			}
			html, body {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-size: .95em;
			}
			.paper .label {
				width: 54mm;
				height: 74mm;
				padding: 0;
				margin: 0;
				box-sizing: border-box;
				// border: 1px solid red;
				position: relative;
			}
			.paper .label .wrapper {
				transform: rotate(90deg);
				width: 74mm;
				height: 54mm;
				position: absolute;
				top: 10mm;
				left: -10mm;
				// border: 1px solid blue;
				box-sizing: border-box;
				padding: 0;
			}
			table {
				width: 100%;
			}
		</style>
	</body>
</html>
