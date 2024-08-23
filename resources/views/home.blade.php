@extends('layout.app')
@section('main')

<div class="container mt-3 pb-5">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-3">Books</h2>
                    <div class="mt-2">
                        <a href="{{ route('home') }}" class="text-dark">Clear</a>
                    </div>
                </div>
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-lg-11 col-md-11">
                                <input type="text" class="form-control form-control-lg" placeholder="Search by title" name="keyword">
                            </div>
                            <div class="col-lg-1 col-md-1">
                                <button class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-magnifying-glass"></i></button>                                                                    
                            </div>                                                                                
                        </div>
                        </form>  
                    </div>
                </div>
                <div class="row mt-4">  
                    @if ($book)
                    @foreach ($book as $books)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card border-0 shadow-lg">
                        <a href="{{ route('home.detail',$books->id) }}">
                            @if ($books->image != '')
                                <img src="{{ asset('uploads/books/'.$books->image) }}" alt="" class="card-img-top">
                            @else 
                            <img src="https://placehold.co/910x1400" alt="" class="card-img-top">
                            @endif
                            </a>
                            <div class="card-body">
                                <h3 class="h4 heading"><a href="{{ route('home.detail',$books->id) }}">{{ $books->title }}</a></h3>
                                <p>{{ $books->author }}</p>
                                <!-- // sum of total revies / review count -->
                                 @php  
                                   if ($books->review_count > 0){
                                    $avgRating = $books->review_sum_rating/$books->review_count;
                                   }else{
                                     $avgRating = 0;
                                   }
                                 $avgRatingPer = ($avgRating * 100) / 5;
                                 @endphp

                                <div class="star-rating d-inline-flex ml-2" title="">
                                    <span class="rating-text theme-font theme-yellow">{{ number_format($avgRating,1) }}</span>
                                    <div class="star-rating d-inline-flex mx-2" title="">
                                        <div class="back-stars ">
                                            <i class="fa fa-star " aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
        
                                            <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="theme-font text-muted">({{ ($books->review_count > 1) ? $books->review_count.' Reviews' : $books->review_count.' Review' }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h3 class="h4 heading">Books Not Found</h3>
                    @endif
                    {{ $book->links('pagination::bootstrap-5') }}   
                    
                </div>
            </div>
        </div>
    </div> 
    @endsection