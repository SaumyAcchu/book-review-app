@extends('layout.app')
@section('main')
<div class="container mt-3 ">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
                </a>
                <div class="row mt-4">
                    <div class="col-md-4">
                    @if ($book->image != '')
                                <img src="{{ asset('uploads/books/'.$book->image) }}" alt="" class="card-img-top">
                            @else 
                            <img src="https://placehold.co/910x1400" alt="" class="card-img-top">
                            @endif
                    </div>
                    <div class="col-md-8">
                    @include('layout.message')
                        <h3 class="h2 mb-3">{{ $book->title }}</h3>
                        <div class="h4 text-muted">{{ $book->author }}</div>
                     
                        @php  
                        if ($book->review_count > 0){
                            $avgRating = $book->review_sum_rating/$book->review_count;
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
                            <span class="theme-font text-muted">({{ ($book->review_count >1 ) ? $book->review_count.' Reviews' : $book->review_count.' Review' }})</span>
                        </div>

                        <div class="content mt-3">
                        {{ $book->description }}
                        </div>

                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h2 class="h3 mb-4">Readers also enjoyed</h2>
                            </div>
                            @if (!empty($reletedBook))
                            @foreach($reletedBook as $releted)
                            <div class="col-md-4 col-lg-4 mb-4">
                                <div class="card border-0 shadow-lg">
                                <a href="{{ route('home.detail',$releted->id) }}">
                                @if ($releted->image != '')
                                <img src="{{ asset('uploads/books/'.$releted->image) }}" alt="" class="card-img-top">
                                @else 
                                 <img src="https://placehold.co/881x1360" alt="" class="card-img-top">
                                 @endif
                                 </a>
                                    <div class="card-body">
                                        <h3 class="h4 heading">{{ $releted->title }}</h3>
                                        <p> {{ $releted->author }}</p>
                                        @php  
                        if ($releted->review_count > 0){
                            $avgRating = $releted->review_sum_rating/$releted->review_count;
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
                                            <span class="theme-font text-muted">({{ ($releted->review_count >1 ) ? $releted->review_count.' Reviews' : $releted->review_count.' Review' }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            @endforeach  
                            @endif        
                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12  mt-4">
                                <div class="d-flex justify-content-between">
                                    <h3>Reviews</h3>
                                    <div>
                                        @if (Auth::check())
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Add Review
                                          </button>
                                          @else 
                                          <a href="{{ route('account.login') }}" class="btn btn-primary">Add Review</a>
                                          @endif
                                          
                                    </div>
                                </div>                        
                                @if ($book->review->isNotEmpty())
                                @foreach($book->review as $review)
                               
                                <div class="card border-0 shadow-lg my-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-3">{{ $review->user->name }}</h4>
                                            <span class="text-muted">
                                            {{ \Carbon\Carbon::parse($review->created_at)->format('d M, Y') }}
                                            </span>         
                                        </div>
                                       @php
                                        $ratingPer = ($review->rating * 100) / 5;
                                        @endphp
                                        <div class="mb-3">
                                            <div class="star-rating d-inline-flex" title="">
                                                <div class="star-rating d-inline-flex " title="">
                                                    <div class="back-stars ">
                                                        <i class="fa fa-star " aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                    
                                                        <div class="front-stars" style="width:{{ $ratingPer }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                                               
                                        </div>
                                        <div class="content">
                                            <p>
                                                {{ $review->review }}
                                            </p>
                                         </div>
                                    </div>
                                </div>  
                                @endforeach
                                @else 
                                <div>
                                    Review not found.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>   
    
    <!-- Modal -->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>Atomic Habits</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" name="bookReviewForm" id="bookReviewForm">
                    <input type="hidden" name="book_id"  value="{{ $book->id }}" />
                  <div class="modal-body">
                        <div class="mb-3">
                            <label for="review" class="form-label">Review</label>
                            <textarea name="review" id="review" class="form-control" cols="5" rows="5" placeholder="Review"></textarea>
                            <p class="invalid-feedback" id="review-error">  </p>
                        </div>
                        <div class="mb-3">
                            <label for="rating"  class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <span class="text-danger" id="review-error">  </span>
                        </div>
                        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$('#bookReviewForm').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '{{ route('home.saveReview') }}',
        type: 'POST',
        headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}' 
                 },
        data: $("#bookReviewForm").serializeArray(),
        success: function(response){
              if (response.status == false){
                var errors = response.errors;
                if (errors.review){
                    $("#review").addClass('is-invalid'); // Corrected selector
                    $("#review-error").html(errors.review);
                }else{
                    $("#review").removeClass('is-invalid');
                    $("#review-error").html( );
                }
              }else{
                window.location.href='{{ route("home.detail",$book->id) }}'
              }
        }
    });
});
</script>
@endsection