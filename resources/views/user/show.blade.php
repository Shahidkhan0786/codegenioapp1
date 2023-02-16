@extends('user.master')

@section('title', 'show user')

@section('content')
<h4 class="p-3 text-center bg-dark text-white">SHOW USER</h4>
    <div class="container">
        {{-- {{$user}} --}}
       
        <div class="container">
            <div class="row">
                <div class="col">
                    <table class="table table-responsive table-striped" style="width:100%">
                        <tr>
                          <th>FirstName:</th>
                          <td>{{$user->firstName}}</td>
                        </tr>
                        <tr>
                            <th>LastName:</th>
                            <td>{{$user->lastName}}</td>
                        </tr>
                        <tr>
                            <th>DOB:</th>
                            <td>{{$user->DOB}}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th>UserType:</th>
                            <td>{{$user->userType}}</td>
                        </tr>
                      </table>
                </div>
                <div class="container">
                    <a href="/users" class="btn btn-success">back</a>
                    <a href="{{route('users.edit' , $user->id)}}" class="btn btn-success">update</a>

                </div>
            </div>
        </div>
    </div>
@endsection
