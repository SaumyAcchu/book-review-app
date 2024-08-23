<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\review;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\validator;

class ReviewController extends Controller
{
    //this method will show review in backend
    public function index(Request $request){
        $query = Review::query();
    
        // Apply filtering on reviews
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
    
            $query->where(function($q) use ($keyword) {
                $q->where('review', 'like', '%' . $keyword . '%')
                  ->orWhereHas('book', function($q) use ($keyword) {
                      $q->where('title', 'like', '%' . $keyword . '%');
                  });
            });
        }
    
        // Apply eager loading and sorting
        $review = $query->with('book')->orderBy('created_at', 'desc')->paginate(10);
    
        return view('review.list', compact('review'));
    }
    public function edit(string $id){
        $review = review::findOrFail($id);
        return view('review.edit',[
            'review' => $review
        ]);

    }
    public function update(Request $request, string $id){
        $validator = validator::make($request->all(),[
            'review' => 'required',
            'status' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $review = review::find($id);
        $review->review =  $request->review;
        $review->status =  $request->status;
        $review->save();
        return redirect()->route('review.index')->with('status',' Review Updated Successfully.');

    }
    public function delete(Request $request){
        $review = review::find($request->id);
        $review->delete();
        session()->flash('status','Review Deleted Successfully');
        return response()->json(
            [
                'status' => true,
                'message' => "Review Deleted Successfully",
            ]);
    }
    public function myReview(){
        $review= review::where('user_id',auth::user()->id)->orderBy('created_at','DESC')->paginate(3);
        return view('review.my_review',compact('review'));
    }
    public function myReview_edit(string $id){
        $review = review::findOrFail($id);
        return view('review.my_review_edit',[
            'review' => $review
        ]);

    }
    public function myReview_update(Request $request, string $id){
        $validator = validator::make($request->all(),[
            'review' => 'required',
            'status' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $review = review::find($id);
        $review->review =  $request->review;
        $review->status =  $request->status;
        $review->save();
        return redirect()->route('review.myReview')->with('status',' Review Updated Successfully.');


    }
    public function myReview_delete(Request $request){
        $review = review::find($request->id);
        $review->delete();
        session()->flash('status','Review Deleted Successfully');
        return response()->json(
            [
                'status' => true,
                'message' => "Review Deleted Successfully",
            ]);
    }
    
}
