@extends('layouts.app')

@section('content')
<div class="container orders">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">Orders</div>

				<div class="card-body">
					<button type="button" class="btn btn-primary" id="print_labels">Print Labels</button>
					<!-- <button type="button" class="btn btn-primary" id="print_po">Print Purchase Orders</button> -->
					<table class="table table-striped">
						<tr>
							<th>Order Number</th>
							<th>Products</th>
							<th>Order Price</th>
							<th>Pre Order</th>
							<th><label for="print_all">Print</label> <input class="print_all" name="print_all" type="checkbox" /></th>
						</tr>
						@foreach ($orders as $order)
						<tr>
							<td>{{ $order['name'] }}</td>
							<td>
								<table style="width: 100%">
									@foreach($order['line_items'] as $product)
									<tr style="background-color: inherit">
										<td style="width:80%">{{ $product['name'] }}</td>
										<td style="width:10%">{{ $product['quantity'] }}</td>
										<td style="width:10%">{{ $product['price'] }}</td>
									</tr>
									@endforeach
								</table>
							</td>
							<td>{{ $order['total_price'] }}</td>
							@if($order['preorder'])
							<td style="color:#f00; font-weight: 800">Pre&#8209;Order</td>
							@else
							<td></td>
							@endif
							<td style="width:5%"><input class="to_print" type="checkbox" data-orderid="{{ $order['id'] }}"/></td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
			<div class="pages">
				@for ($i = 1; $i < $page_count; $i++)
				<a href="?page={{ $i }}">{{ $i }}</a>
				@endfor 
			</div>
		</div>
	</div>
</div>
	<script>
	</script>
@endsection
