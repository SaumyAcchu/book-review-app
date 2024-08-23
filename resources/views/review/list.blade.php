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
                        My Reviews
                    </div>
                    <div class="card-body pb-0">  
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('review.index') }}">
                                <div class="d-flex">
                                    <input type="text" name="keyword" placeholder="Keyword." value="" class="form-control">
                                    <button type="submit" class="btn btn-primary">Search</button>
                             </div>
                            </form>
                        </div>
                                  
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Date</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if ($review->isNotEmpty())
                                    @foreach ($review as $reviewDa)
                                    <tr>
                                        <td>{{ $reviewDa->book->title }}</td>
                                        <td>{{ $reviewDa->review }}</td>                                        
                                        <td>{{ $reviewDa->rating }}</td>
                                        <td> @if ($reviewDa->status==1)
                                            <span class="text-success">Active</span>
                                            @else
                                            <span class="text-danger">Block</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($reviewDa->created_at)->format('d M/Y')}}</td>
                                        <td>
                                            <a href="{{ route('review.edit',$reviewDa->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="deleteReview( {{ $reviewDa->id }} );"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>  
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6"> Data Not Found</td>
                                   </tr>
                                    @endif
                                                               
                                </tbody>
                            </thead>
                        </table>   
                       {{ $review->links('pagination::bootstrap-5')}}                 
                    </div>
                    
                </div>  
            
            </div>
        </div>       
    </div>

@endsection
@section('script')
<script>
    function deleteReview(id) {
        // alert(id);
        $.ajax({
            url:'{{ route('review.delete') }}',
            type:'delete',
            data:{id:id},
            headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}' 
                 },
            success:function(response){
                //  alert(response.message);
                 window.location.href = '{{ route("review.index") }}';
            }
        })
    }
    
</script>
@endsection