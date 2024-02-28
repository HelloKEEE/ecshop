@extends('layouts.app')
 
@section('title', 'product detail')

@section('content')
    <body class="antialiased">
        <div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            your cart's detail
            </div>
            <br/>
            <table class="table table-striped" style="width: 60% ; margin:auto; ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Your Name</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>order time</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $cart->id}}</td>
                        <td>{{ $cart->user->name}}</td>
                        <td>{{ $cart->product->name}}</td>
                        <td>{{ $cart->quantity}}</td>
                        <td>{{ $cart->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>

            
    </body>

@endsection
