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
                        Add Book
                    </div>
                    <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Title" name="title" id="title" />
                            <span class="text-danger"> @error('title') {{ $message }} @enderror </span>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror" placeholder="Author"  name="author" id="author"/>
                            <span class="text-danger"> @error('author') {{ $message }} @enderror </span>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" cols="30" rows="5"></textarea>
                            <span class="text-danger"> @error('description') {{ $message }} @enderror </span>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('message') is-invalid @enderror"  name="image" id="image"/>
                            <span class="text-danger"> @error('image') {{ $message }} @enderror </span>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                            <span class="text-danger"> @error('status') {{ $message }} @enderror </span>
                        </div>


                        <button type="submit" class="btn btn-primary mt-2">Create</button>                     
                    </div>
                    </form>
                </div>  
            </div>
        </div>       
    </div>

@endsection