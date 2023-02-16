@extends('user.master')
@section('title' ,'posts')

@section('content')
<div class="container p-5">
    <div class="button d-flex justify-content-end">
        <button href="{{ url('/users/create') }}" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="fa fa-plus"></i>
            Create New Post
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
                    <h4 class="modal-title">Create Post</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{ route('post.create')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create</button>
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
    
    <div class="container mt-2">
        {{-- {{$posts}} --}}
        @foreach($posts as $post)
        <p class="bg-secondary p-5 ">{{$post->content}}</p>
        @endforeach
    </div>
</div>
@endsection