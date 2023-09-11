@extends('layouts.master')

@section('top_script')
<style type="text/css">
    
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{ __('You are logged in!') }}
            </div>
        </div>

        <br>

        <div class="row">

            @foreach($products as $product)
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

                        <span style="font-weight: bold; font-size: 20px;">RM {{ number_format($product->price, 2) }}</span><br>
                        <a href="{{ route('order', $product->id) }}" class="btn btn-danger">Buy Now</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </div>
</div>
@endsection

@section('bottom_script')
<script>
    
</script>
@endsection
