@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of all orders
	</div>
	<div class="card-body">

		@if(Session::has('message'))
    	<div class="alert alert-success">
    		{{ Session::get('message') }}
    	</div>
    	@endif

    	<div class="row">
    		<div class="col-md-3">
    			<form method="GET" action="{{ route('order.index') }}">
    			<table class="w-100">
    				<tr>
    					<td>
    						<input type="text" class="form-control" name="search" value="{{ $search }}">
    					</td>
    					<td>
    						<button type="submit" class="btn btn-primary">Search</button>
    					</td>
    				</tr>
    			</table>
    			</form>
    		</div>
    		<div class="col-md-3">
    			<select class="form-control" onchange="self.location='{{ route('order.index') }}?status='+this.value">
    				<option value="ALL" @if($status == 'ALL') selected @endif>ALL</option>
    				<option value="0" @if($status == '0') selected @endif>Pending</option>
    				<option value="1" @if($status == '1') selected @endif>Complete</option>
    				<option value="2" @if($status == '2') selected @endif>Rejected</option>
    			</select>
    		</div>
    		<div class="col-md-6">
    			<div style="float:right;">
    				<a href="{{ route('order.pdf') }}" class="btn btn-primary">Export PDF</a>
    				<a href="{{ route('order.excel') }}" class="btn btn-primary">Export Excel</a>
    			</div>
    		</div>
    	</div>

    	<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Date Order</th>
				<th>Customer Name</th>
				<th>Product</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
				<th>Status</th>
				<th>Proof</th>
				<th>Action</th>
			</tr>
			@php($i = isset($_GET['page']) ? (($_GET['page'] - 1) * 5) : 0)
			@foreach($orders as $order)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $order->created_at->format('d/m/Y') }}</td>
				<td>{{ $order->user->name }}</td>
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
				<td>
					<form method="POST" action="{{ route('order.update', $order->id) }}">
						<input type="hidden" name="_method" value="PUT">
						@csrf
						<button type="submit" name="submit" value="approve" class="btn btn-sm btn-success">Approve</button>
						<button type="submit" name="submit" value="reject" class="btn btn-sm btn-danger">Reject</button>
					</form>
				</td>
			</tr>
			@endforeach
		</table>

		{!! $orders->render() !!}

	</div>
</div>
@endsection