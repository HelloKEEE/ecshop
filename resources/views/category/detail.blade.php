@extends('layouts.app')
 
@section('title', '新規カテゴリー')

@section('content')
    <body class="antialiased">
        <div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                category information
            </div>
            <br/>
            <table class="table table-striped" style="width: 60% ; margin:auto; ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $category->id}}</td>
                        <td>{{ $category->name}}</td>
                    </tr>
                </tbody>
            </table>
            <br>

            @if($category->products && $category->products->count() > 0)  
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                Product information when it has this id
            </div>
            <table class="table table-striped" style="width: 60% ; margin:auto; ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($category->products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            @endif
    </body>

@endsection
