@extends('layouts.app')
 
@section('title', 'product detail')

@section('content')
    <body class="antialiased">
        <div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            product information
            </div>
            <br/>
            <table class="table table-striped" style="width: 60% ; margin:auto; ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>category_id</th>
                        <th>category_introduction</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $product->id}}</td>
                        <td>{{ $product->name}}</td>
                        <td>{{ $product->category_id}}</td>
                        <td>{{ $product->category->introduction}}</td>
                    </tr>
                </tbody>
            </table>
            <br>

            
    </body>

@endsection
