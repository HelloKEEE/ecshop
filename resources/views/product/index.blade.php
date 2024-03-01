@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="">
        <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            All products
        </div>

        <div class="badge btn btn-outline-primary text-wrap" style="width: 20rem;">
            <p><a href="{{ route('product.add') }}">新規作成</a></p>
        </div>
        <br/>

        <div class="container">

            <h2>Search data</h2>

            <form method="GET" action="{{ route('product.index')}}">
                <table class="table table-striped" style="width: 60% ; margin:auto; ">
                    <tbody>
                    <tr>
                        <th>ID:</th>
                        <th><input type="text" name="id" value="{{ $_GET["id"] ?? old('id')  }}"></input></th>
                    </tr>

                    <tr>
                        <th>Name:</th>
                        <th><input type="text" name="name" value="{{ $_GET["name"] ?? '' }}"></input></th>
                    </tr>
                    <tr>
                        <th>Price:</th>
                        <th><input type="text" name="price" value="{{ $_GET["price"] ?? '' }}"></input></th>
                    </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>


            @error('quantity')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>price</th>
                    <th>category ID</th>
                    <th>Stock</th>
                    <th>Move</th>
                    <th>
                        <div style="margin: 0 auto; text-align: center;">

                            <form method="POST" action="{{ route('cart.index') }}">
                                @csrf
                                <button class="btn btn-danger" type="submit">check cart</button>
                            </form>
                            Cart
                        </div>
                    </th>

                </tr>
                </thead>
                <tbody>

                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->category_id }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><a href="{{ route('product.detail', ['id' => $product->id]) }}">詳細</a>
                            <a href="{{ route('product.edit', ['id' => $product->id]) }}">編集</a>
                            <a href="{{ route('product.delete', ['id' => $product->id]) }}">削除</a></td>
                        <td>
                            <form method="POST" action="{{ route('cart.add')}}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}"></intput>
                                <input type="number" name="quantity" value="1" min="1">
                                <button class="btn btn-warning" type="submit">追加</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
