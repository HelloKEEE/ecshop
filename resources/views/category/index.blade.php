@extends('layouts.app')
 
@section('title', 'カテゴリー')
 
@section('content')
    <div class="">
        <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            All categories
        </div>

        <div class="badge btn btn-outline-primary text-wrap" style="width: 20rem;">
            <p><a href="{{ route('category.add') }}">新規作成</a></p>
        </div>
            <br/>

            <div class="container">
        
            <h2>Search data</h2>

            <form method="GET" action="{{ route('category.index')}}">
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
                            <th>Introduction:</th>
                            <th><input type="text" name="introduction" value="{{ $_GET["introduction"] ?? '' }}"></input></th>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" >Search</button>
            </form>    

            @error('id')
                    <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Introduction</th>
                    <th>Match products</th>
                    <th>Move</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->introduction }}</td>
                    <th>{{ $category->products->count() }}</th>
                    <td><a href="{{ route('category.detail', ['id' => $category->id]) }}">詳細</a>
                        <a href="{{ route('category.edit', ['id' => $category->id]) }}">編集</a>
                        <a href="{{ route('category.delete', ['id' => $category->id]) }}">削除</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
