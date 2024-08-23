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
                        Books
                    </div>
                    <div class="card-body pb-0">   
                        <div class="d-flex justify-content-between">
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
            
                        <form action="{{ route('books.index') }}" methid="post">
                        <div class="d-flex">
                          <input type="text" class="form-control" placeholder="Keyword" name="keyword" value="{{ Request::get('keyword') }}">
                          <button type="submit" class="btn btn-primary">Search</button>
                          <a href="{{ route('books.index') }}" class="btn btn-secondary ms-2">Clear</a>
                          </div>  
                        </form>
                        
                        </div>         
                                  
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                                <tbody>
                                    @if ($book->isNotEmpty())
                                    @foreach($book as $boo)
                                    <tr>
                                        <td>{{ $boo->title }}</td>
                                        <td>{{ $boo->author }}</td>
                                        <td>3**</td>
                                        <td>
                                            @if($boo->status=="1")
                                            <span class="text-success">Active</span>
                                            @else
                                            <span class="text-danger">De-active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm"><i class="fa-regular fa-star"></i></a>
                                            <a href="{{ route('books.edit',$boo->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" onclick="deleteBook({{ $boo->id }});" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">Bokk Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </thead>
                        </table>   
                        {{ $book->links('pagination::bootstrap-5') }}              
                    </div>
                    
                </div> 
            </div>
        </div>       
    </div>

@endsection
@section('script')
<script>
    function deleteBook(id){
        if (confirm("Are you sure you want to delete?")){
            $.ajax({
                url: '{{ route("books.destroy")}}',
                type: 'delete',
                data: {id:id},
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}' 
                 },
                success: function(response){
                    // alert(response.message);
                    window.location.href = '{{ route("books.index") }}';
                }
            });
        }
    }
</script>
@endsection