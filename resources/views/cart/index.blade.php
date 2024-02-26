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
                <button type="submit" class="btn btn-primary" >Search</button>
            </form>    



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>price</th>
                    <th>category ID</th>
                    <th>Move</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <th>{{ $product->category_id }}</th>
                    <td><a href="{{ route('product.detail', ['id' => $product->id]) }}">詳細</a>
                        <a href="{{ route('product.edit', ['id' => $product->id]) }}">編集</a>
                        <a href="{{ route('product.delete', ['id' => $product->id]) }}">削除</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
