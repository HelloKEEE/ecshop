@extends('layouts.app')
 
@section('title', 'user detail')

@section('content')
    <body class="antialiased">
        <div class="">
            <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            user information
            </div>
            <br/>
            <table class="table table-striped" style="width: 60% ; margin:auto; ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $user->id}}</td>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->password}}</td>
                    </tr>
                </tbody>
            </table>
            <br>

            
    </body>

@endsection
