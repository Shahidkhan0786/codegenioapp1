@extends('user.master')

@section('title' , 'edit user')


@section('content')
<h3 class="bg-dark p-3">Edit User</h3>
<div class="container">
    {{-- error message  --}}
    @if ($errors->any())
        <div class="alert alert-danger">
        There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 {{-- error message  --}}
    <div class="row">
        <div class="col">
            {{-- {{$user}} --}}
            <form action="{{ route('users.update',$user->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exampleInputfname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="exampleInputfname" name="firstName" aria-describedby="firstHelp" value="{{$user->firstName}}">
                    
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputlname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="exampleInputlname" name="lastName" aria-describedby="firstHelp" value="{{$user->lastName}}">
                    
                </div>
                
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{$user->email}}">
                  
                </div>

                <div class="mb-3">
                    <label for="exampleInputlname" class="form-label">DOB</label>
                    <input type="datetime-local" class="form-control" name="DOB" id="exampleInputlname" value="{{$user->DOB}}">
                </div>


                {{-- <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="password" >
                </div> --}}

                {{-- <select class="form-select mb-2" aria-label="Default select example" name="userType">
                    <option selected>User Type</option>
                    <option value="user">USER</option>
                    <option value="writer">WRITER</option>
                </select> --}}


               
                <button type="submit" class="btn btn-primary">update</button>
            </form> 
        </div>
    </div>
</div>
@endsection