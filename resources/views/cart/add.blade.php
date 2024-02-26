<!-- resources/views/child.blade.php -->
@extends('layouts.app')
 
@section('title', 'product add')
 

 
@section('content')
<div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                write name price and category_id
            </div>



            <form method="post" action="{{ route('product.add')}}">
                @csrf
                <p>Name:</p>
                <input type="text" name="name" value="{{ old('name') }}"></input>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <p>Price:</p>
                <input type="text" name="price" value="{{ old('price') }}" ></input>
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <p>Category's ID:</p>
                <select name="category_id">
                    <option value="">カテゴリを選択してください</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(old("category_id") == $category->id) selected @endif)>{{ $category->name }}</option>
                    @endforeach
                    
                </select>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <br/><br/>
                <button type="submit" class="btn btn-primary" >send</button>
            </form>
       
</div>


@endsection
