<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\review;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   public function index(Request $request){
      
    $book = book::withCount('review')->withSum('review','rating')->orderBy('created_at','DESC');
    if (!empty($request->keyword)){
      $book->where('title','like','%'.$request->keyword.'%')
           ->orWhere('author','like','%'.$request->keyword.'%');
     }
           $book = $book->paginate(8);
         //   dd($book);
    return view('home',compact('book'));
   }

   //details page
   public function detail(string $id){
      $book = book::with(['review.user','review'=> function($query){
          $query->where('status','1');
      }])->withCount('review')->withSum('review','rating')->find($id);
      // dd($book);
      $reletedBooks = book::withCount('review')
                           ->withSum('review','rating')
                           ->where('status','1')
                           ->where('id','!=',$id)
                           ->take(3)
                           ->inRandomOrder()->get();
      return view('book-detail',[
         'book' =>$book,
         'reletedBook' =>$reletedBooks
      ]);

   }
   
   public function saveReview(Request $request)
   {
      $validator = validator::make($request->all(),[
         'review' => 'required|min:10',
         'rating' =>  'required',
      ]);
      if($validator->fails()){
         return response()->json([
            'status' => false,
            'errors' =>$validator->errors()
         ]);
      }

      /// Apply Condition Here
      $countReview = review::where('user_id',Auth::user()->id)
                           ->where('book_id',$request->book_id)
                           ->count();
      if ($countReview>0){
         session()->flash('error','You already submitted a review.');
      }else{
      $review = new review();
      $review->review = $request->review;
      $review->rating = $request->rating;
      $review->user_id = Auth::user()->id;
      $review->book_id = $request->book_id;
      $review->save();
      session()->flash('status','Review submitted successfull');
      return response()->json([
         'status' =>true,
      ]);
   }

   }
}
