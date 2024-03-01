@extends('layouts.app')

@section('title', 'product detail')

@section('content')
    <body class="antialiased">
        <div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            your cart's detail
            </div>
            <br/>
            <div style="text-align: right;" >
                  <form method="POST" action="{{ route('cart.clear') }}" style="display: inline-block; margin-right: 250px; margin-top: 20px; margin-bottom: 20px;">
                      @csrf
                      <button type="submit" class="btn btn-danger">clear all</button>
                  </form>
            </div>

            @error('quantity')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <table class="table table-striped" style="width: 60% ; margin:auto; vertical-align: middle;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Your Name</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th width="100"></th>
                        <th>Product's stock</th>
                        <th width="100">Newest Order</th>
                        <th></th>
                        <th>move</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $cart->id}}</td>
                        <td>{{ $cart->user->name}}</td>
                        <td>{{ $cart->product->name}}</td>
                        <form method="POST" action="{{ route('cart.update')}}">
                            @csrf
                            <td><input type="number" name="quantity" value="{{ $cart->quantity }}" min="0" max="{{ $cart->product->stock + $cart->quantity }}">
                            <input type="hidden" name="product_id" value="{{ $cart->product_id }}">
                                <input type="hidden" name="cart_quantity" value="{{ $cart->quantity }}"></td>
                            <td><button class="btn btn-dark" type="submit" >変更</button></td>
                        </form>
                        <td>{{ $cart->product->stock}}</td>
                        <td>{{ $cart->updated_at}}</td>

                        <td><form method="POST" action="{{ route('cart.increase') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $cart->product->id }}">
                            <button type="submit" class="btn btn-dark">増加</button>
                            </form></td>

                        <td><form method="POST" action="{{ route('cart.reduce') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $cart->product->id }}">
                                <button type="submit" class="btn btn-dark">減る</button>
                            </form></td>

                        <td><form method="POST" action="{{ route('cart.remove') }}">
                            @csrf <!-- Laravel CSRF 保護 -->
                            <!-- 在這裡添加您想要傳遞的值 -->
                            <input type="hidden" name="product_id" value="{{ $cart->product->id }}">
                            <button type="submit" class="btn btn-dark">削除</button>
                        </form></td>


                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>


    </body>

@endsection
