@extends('layouts.app')
 
@section('title', 'Users')
 
@section('content')
<div class="container">
        <div class="login-container">
            <h2 class="mb-4">Login</h2>

            

            <form method= "POST" action="{{ route('login')}}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label" >Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
        </div>
    </div>
@endsection