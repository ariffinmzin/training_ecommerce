<html>

<head>
	<title>Lis of All Orders</title>
</head>

<body>
	<table class="" border="1" cellpadding="2" cellspacing="0" style="width:100%">
		<tr style="background-color: #EEE;">
			<th>#</th>
			<th style="background-color: #EEE; border: 5px solid #000;">Date Order</th>
			<th style="background-color: #EEE; border: 5px solid #000;">Customer Name</th>
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
			<td>{{ $order->created_at->format('d/m/Y') }}</td>
			<td>{{ $order->user->name }}</td>
			<td>{{ $order->product->name }}</td>
			<td>{{ $order->quantity }}</td>
			<td>{{ number_format($order->product->price, 2) }}</td>
			<td>{{ number_format($order->total, 2) }}</td>
			<td>
				@if($order->status == 0)
					<span style="background-color:orange;">Pending</span>
				@elseif($order->status == 1)
					<span style="background-color:green;">Complete</span>
				@else
					<span style="background-color:red">Rejected</span>
				@endif
			</td>
			<td>
				<a href="{{ asset('uploads/proof/'.$order->proof) }}" class="">{{ $order->proof }}</a>
			</td>
		</tr>
		@endforeach
	</table>

</body>
</html>

		