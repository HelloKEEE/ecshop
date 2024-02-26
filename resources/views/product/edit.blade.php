<!-- resources/views/child.blade.php -->
@extends('layouts.app')
 
@section('title', '編集')
 
@section('content')
<div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                Write ID , Name , price and category_id </br> then Name , price and category_id will be changed by ID.
            </div>



            <form method="POST" action="{{ route('product.edit')}}">
                @csrf

                    <p>ID:</p>
                    <input type="text" name="id" value="{{ $_GET['id'] ?? old('id') }}" ></input>
                @error('id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

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

                    <p>category_id:</p>
                    <input type="text" name="category_id" value="{{ old('category_id') }}" ></input>
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                    <br/><br/>
                    <button type="submit" class="btn btn-primary" >send</button>
            </form>
       
</div>



@endsection
