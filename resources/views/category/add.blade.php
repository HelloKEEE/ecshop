<!-- resources/views/child.blade.php -->
@extends('layouts.app')
 
@section('title', '新規カテゴリー')
 

 
@section('content')
<div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
                write name and introduction
            </div>



            <form method="post" action="{{ route('category.add')}}">
                @csrf
                <p>name:</p>
                <input type="text" name="name" value="{{ old('name') }}"></input>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <p>introduction:</p>
                <input type="text" name="introduction" value="{{ old('introduction') }}" ></input>
                @error('introduction')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <br/><br/>
                <button type="submit" class="btn btn-primary" >send</button>
            </form>
       
</div>


@endsection
