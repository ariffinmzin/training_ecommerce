@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of my orders
	</div>
	<div class="card-body">

		@if(Session::has('message'))
    	<div class="alert alert-success">
    		{{ Session::get('message') }}
    	</div>
    	@endif

    	<a href="{{ route('home') }}" class="btn btn-primary mb-2">Add New Order</a>
		
		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Date Order</th>
				<th>Product</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
				<th>Status</th>
				<th>Proof</th>
			</tr>
			@php($i = 0)
			@foreach($orders as $order)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $order->created_at }}</td>
				<td>{{ $order->product->name }}</td>
				<td>{{ $order->quantity }}</td>
				<td>{{ number_format($order->product->price, 2) }}</td>
				<td>{{ number_format($order->total, 2) }}</td>
				<td>
					@if($order->status == 0)
						<span class="badge bg-warning">Pending</span>
					@elseif($order->status == 1)
						<span class="badge bg-success">Complete</span>
					@else
						<span class="badge bg-danger">Rejected</span>
					@endif
				</td>
				<td>
					<a href="{{ asset('uploads/proof/'.$order->proof) }}" class="">{{ $order->proof }}</a>
				</td>
			</tr>
			@endforeach
		</table>

	</div>
</div>
@endsection