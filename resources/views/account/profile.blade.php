@extends('layout.app')
@section('main')
<div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header  text-white">
                        Welcome, {{ Auth::user()->name }}                       
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if (Auth::user()->image != "")
                            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid rounded-circle" alt="Luna John">
                            @endif                            
                        </div>
                        <div class="h5 text-center">
                            <strong> {{ Auth::user()->name }} </strong>
                            <p class="h6 mt-2 text-muted">5 Reviews</p>
                        </div>
                    </div>
                </div>
              @include('layout.sidebar')
            <div class="col-md-9">
            @include('layout.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Profile
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.updateProfile') }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="form-control" placeholder="Name" name="name" id="" />
                            <span class="text-danger"> @error('name') {{ $message }} @enderror </span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="text" value="{{ Auth::user()->email }}" class="form-control" placeholder="Email"  name="email" id="email"/>
                            <span class="text-danger"> @error('email') {{ $message }} @enderror </span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <span class="text-danger"> @error('image') {{ $message }} @enderror </span>
                            @if (Auth::user()->image != "")
                            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image) }}" class="img-fluid mt-4" alt="Luna John">
                            @endif 
                            <!-- <img src="images/profile-img-1.jpg" class="img-fluid mt-4" alt="Luna John" > -->
                        </div>   
                        <button class="btn btn-primary mt-2">Update</button> 
                        </form>                    
                    </div>
                </div>                
            </div>
        </div>       
    </div>

@endsection