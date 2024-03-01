<!-- resources/views/child.blade.php -->
@extends('layouts.app')
 
@section('title', 'cart add')
 

 
@section('content')
<div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                product's name and quantity 
            </div>



            <form method="post" action="{{ route('cart.add')}}">
                @csrf

                <p>User's Name:</p>
                <input type="text" name="user_name" value="{{ session('user_name') }}" readonly></input>
                <input type="hidden" name="user_id" value="{{ session('user_id') }}" readonly></input>
                <p>Product's ID:</p>
                <input type="text" name="product_id" value="{{ $product_id ?? old('product_id') }}"></input>
                @error('product_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <p>Quantity:</p>
                <input type="text" name="quantity" value="{{ old('quantity') }}" ></input>
                @error('quantity')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror


                <br/><br/>
                <button type="submit" class="btn btn-primary" >send</button>
            </form>

            <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product's ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    
                </tr>
            @endforeach
            </tbody>
        </table>
       
</div>


@endsection
