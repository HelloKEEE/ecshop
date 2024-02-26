@extends('layouts.app')
 
@section('title', 'Users')
 
@section('content')
    <div class="">

    

        <div class="badge bg-secondary text-wrap" style="width: 60rem;">
            All Users
        </div>

        <div class="badge btn btn-outline-primary text-wrap" style="width: 20rem;">
            <p><a href="{{ route('user.add') }}">新規作成</a></p>
        </div>
            <br/>

            <div class="container">
        
            <h2>Search data</h2>

            <form method="GET" action="{{ route('user.index')}}">
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
                            <th>email:</th>
                            <th><input type="text" name="email" value="{{ $_GET["email"] ?? '' }}"></input></th>
                        </tr>
                        <!-- <tr>
                            <th>email_verified_at:</th>
                            <th><input type="text" name="email_verified_at" value="{{ $_GET["email_verified_at"] ?? '' }}"></input></th>
                        </tr> -->
                        <tr>
                            <th>Password:</th>
                            <th><input type="text" name="password" value="{{ $_GET["password"] ?? '' }}"></input></th>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" >Search</button>
            </form>    



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <!-- <th>Email_verified_at</th> -->
                    <th>Password</th>
                    <th>Move</th>
                </tr>
            </thead>
            <tbody>

            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <!-- <td>{{ $user->email_verified_at }}</td> -->
                    <th>{{ $user->password }}</th>
                    <td><a href="{{ route('user.detail', ['id' => $user->id]) }}">詳細</a>
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}">編集</a>
                        <a href="{{ route('user.delete', ['id' => $user->id]) }}">削除</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
