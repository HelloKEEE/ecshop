<!-- resources/views/child.blade.php -->
@extends('layouts.app')
 
@section('title', 'カテゴリー編集')
 
@section('content')
<div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                Write ID Name and Introduction </br> then Name and Introduction will be changed by ID.
            </div>



            <form method="post" action="{{ route('category.edit')}}">
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

                    <p>Introduction:</p>
                    <input type="text" name="introduction" value="{{ old('introduction') }}" ></input>
                @error('introduction')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                    <br/><br/>
                    <button type="submit" class="btn btn-primary" >send</button>
            </form>
       
</div>



@endsection
