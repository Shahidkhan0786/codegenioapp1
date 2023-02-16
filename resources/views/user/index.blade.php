@extends('user.master')

@section('title' , 'users')

@section('content')
<div class="container p-5">
    <div class="button d-flex justify-content-end">
        <button href="{{ url('/users/create') }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="fa fa-plus"></i>
                Create New User
        </button>
    </div>
    {{-- display message  --}}
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- end display message  --}}

    {{-- model start  --}}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Create User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('storeUser')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputfname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="exampleInputfname" name="firstName" aria-describedby="firstHelp">
                            <div id="firstHelp" class="form-text">FirstName will be minimum 5 characters long.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputlname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="exampleInputlname" name="lastName" aria-describedby="firstHelp">
                            <div id="firstHelp" class="form-text">LastName will be minimum 5 characters long.</div>
                        </div>
                        
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputlname" class="form-label">DOB</label>
                            <input type="datetime-local" class="form-control" name="DOB" id="exampleInputlname">
                        </div>


                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        </div>

                        <select class="form-select mb-2" aria-label="Default select example" name="userType">
                            <option selected>User Type</option>
                            <option value="user">USER</option>
                            <option value="writer">WRITER</option>
                        </select>


                       
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- model end  --}}

   <div class="container">
    <table class="table table-responsive table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Serial_Num</th>
            <th scope="col">Name</th>
            <th scope="col">DOB</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user )
            <tr>
                <th scope="row">{{$loop->index+1}}</th>
                <td>{{$user->firstName}}</td>
                <td>{{$user->DOB}}</td>
                <td>{{$user->email}}</td>
                <td>
                    {{-- <a class="btn btn-success" href="{{ route('showUser',$user->id)}}">edit</a>
                    <a class="btn btn-danger" href="{{ route('deleteUser', $user->id) }}">delete</a> --}}
                    <form action="{{ route('users.destroy',$user->id) }}" method="POST">
   
                        <a class="btn btn-warning" href="{{ route('users.show',$user->id) }}">Show</a>
        
                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
       
                        @csrf
                        @method('DELETE')
          
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
          @endforeach   
        </tbody>
      </table>
      {!! $users->links() !!}
   </div>
</div>
@endsection