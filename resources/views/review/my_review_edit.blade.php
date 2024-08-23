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
                        Review Update
                    </div>

                    <div class="card-body">
                        <form action="{{ route('review.myReview_update',$review->id) }}" method="post">
                            @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Review</label>
                            <textarea name="review" id="review" placeholder="review" class="form-control">{{ old('review',$review->review) }}</textarea>
                            <span class="text-danger"> @error('review') {{ $message }} @enderror </span>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label ">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="1 {{ ($review->review==1) ? 'selected' : ' '  }}">Active</option>
                                <option value="0 {{ ($review->review==0) ? 'selected' : ' '  }}">De-active</option>
                            </select>
                            <span class="text-danger"> @error('status') {{ $message }} @enderror </span>
                        </div>
                       
                        <button class="btn btn-primary mt-2" type="submit">Update</button> 
                        </form>                    
                    </div>
                </div>                
            </div>
        </div>       
    </div>

@endsection