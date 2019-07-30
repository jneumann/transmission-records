@extends('layouts.app')

@section('content')
<div class="container product">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Products</div>

				<div class="card-body">
					<form action="/product">
						<div class="row">
							<div class="col-md-10 form-group">
								<input type="text" name="search" placeholder="Album Title" class="form-control"/>
							</div>
							<div class="col-md-2 form-group">
								<input type="submit" class="btn btn-primary form-control" value="search" />
							</div>
						</div>
					</form>
					<table class="table table-striped">
						<tr>
							<th></th>
							<th></th>
							<th>Pre Order?</th>
						</tr>
						@foreach ($products as $prod) 
						<tr>
							<td style="text-align: center; height: 80px;"><img src="{{ $prod['image']['src'] }}" width="75px" style="max-height: 80px"></td>
							<td>{{ $prod['title'] }}</td>
							<td style="text-align: center">
								@if (in_array('Pre Order', $prod['tags']))
								<input type="checkbox" data-product="{{ $prod['id'] }}" checked>
								@else
								<input type="checkbox" data-product="{{ $prod['id'] }}">
								@endif
							</td>
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
@endsection
