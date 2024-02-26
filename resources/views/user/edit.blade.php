<!-- resources/views/child.blade.php -->
@extends('layouts.app')
 
@section('title', '編集')
 
@section('content')
<div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                Write ID , Name , email and password </br> then Name , email and password will be changed by ID.
            </div>



            <form method="POST" action="{{ route('user.edit')}}">
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

                    <p>Email:</p>
                    <input type="text" name="email" value="{{ old('email') }}" ></input>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                    <p>Password:</p>
                    <input type="text" name="password" value="{{ old('password') }}" ></input>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                    <br/><br/>
                    <button type="submit" class="btn btn-primary" >send</button>
            </form>
       
</div>



@endsection
