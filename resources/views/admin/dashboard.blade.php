@extends('layouts.master')

@section('top_script')
<style type="text/css">
    
</style>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">

        <div class="card">
            <div class="card-header text-center">Total Users</div>

            <div class="card-body text-center">
                <h2>{{ $total_users }}</h2>
            </div>
        </div>

    </div>
    <div class="col-md-3">

        <div class="card">
            <div class="card-header text-center">Total Products</div>

            <div class="card-body text-center">
                <h2>{{ $total_products }}</h2>
            </div>
        </div>

    </div>
    <div class="col-md-3">

        <div class="card">
            <div class="card-header text-center">Total Sales (No)</div>

            <div class="card-body text-center">
                <h2>{{ $total_orders }}</h2>
            </div>
        </div>

    </div>
    <div class="col-md-3">

        <div class="card">
            <div class="card-header text-center">Total Sales (Value)</div>

            <div class="card-body text-center">
                <h2>RM {{ number_format($total_orders_value, 2) }}</h2>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <br>

        <table class="table table-bordered">
            <tr>
                <th></th>
                <th style="text-align: right;">Sales (no)</th>
                <th style="text-align: right;">Sales (RM)</th>
            </tr>
            <tr>
                <th class="bg-warning text-white">Pending</th>
                <td style="text-align: right;">{{ $reports[0]['total_sale_no'] }}</td>
                <td style="text-align: right;">RM {{ number_format($reports[0]['total_sale_val'], 2) }}</td>
            </tr>
            <tr>
                <th class="bg-success text-white">Approved</th>
                <td style="text-align: right;">{{ $reports[1]['total_sale_no'] }}</td>
                <td style="text-align: right;">RM {{ number_format($reports[1]['total_sale_val'], 2) }}</td>
            </tr>
            <tr>
                <th class="bg-danger text-white">Reject</th>
                <td style="text-align: right;">{{ $reports[2]['total_sale_no'] }}</td>
                <td style="text-align: right;">RM {{ number_format($reports[2]['total_sale_val'], 2) }}</td>
            </tr>
        </table>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Monthly Sales Graph
            </div>
            <div class="card-body">
                <div id="myfirstchart" style="height: 200px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_script')
<script>
new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    @foreach($graph as $data)
    { year: '{{ $data['month'] }}', value: {{ $data['total'] }} },
    @endforeach
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});
</script>
@endsection
