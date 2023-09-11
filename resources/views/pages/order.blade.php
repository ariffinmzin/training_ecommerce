@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		Order Form
	</div>
	<div class="card-body">

		@if(Session::has('message'))
    	<div class="alert alert-success">
    		{{ Session::get('message') }}
    	</div>
    	@endif
		
		<form method="POST" action="{{ route('order.post') }}" enctype="multipart/form-data">
		<input type="hidden" name="product_id" value="{{ $product->id }}">
		@csrf

			<table class="table">
				<tr>
					<td>Product</td>
					<td>
						
						<div class="row">
							<div class="col-md-3">
								<div class="card mb-4">
				                    <div class="card-header">
				                        {{ $product->name }}
				                    </div>
				                    <div class="card-body">
				                        
				                        @if($product->photo)
				                        <img src="{{ asset('uploads/products/'.$product->photo) }}" style="width:100px;">
				                        @else
				                        <img src="{{ asset('images/nophoto.jpg') }}" style="width:100px;">
				                        @endif

				                        <hr>

				                        <span style="font-weight: bold; font-size: 20px;">RM {{ number_format($product->price, 2) }}</span>
				                    </div>
				                </div>
				            </div>
				        </div>

					</td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td>
						<input type="number" name="quantity" value="{{ old('quantity', $order->quantity) }}" class="form-control">
						@error('quantity')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Remark/Note</td>
					<td>
						<input type="text" name="note" value="{{ old('note', $order->note) }}" class="form-control">
						@error('note')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td>Payment Proof</td>
					<td>
						<input type="file" name="proof" class="form-control">
						@error('proof')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" class="btn btn-primary">
							Submit
						</button>
					</td>
				</tr>
			</table>

		</form>

	</div>
</div>
@endsection