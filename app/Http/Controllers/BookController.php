<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $book = book::orderBy('created_at','DESC');
        
        if (!empty($request->keyword)){
         $book->where('title','like','%'.$request->keyword.'%')
              ->orWhere('author','like','%'.$request->keyword.'%');
        }
        $book = $book->paginate(3);
        return view('books.list',compact('book'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'author' => 'required|min:3',
            'description' => 'required|min:5',
            'status' => 'required',
        ];
        if(!empty($request->image)){
            $rules['image'] = 'image';
        }
        $validator = validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();
        
        //upload book image here
        if(!empty($request->image)){
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time(). '.' .$ext;
            $image->move(public_path('uploads/books'), $imageName);
            $book->image = $imageName;
            $book->save();

          //for images resizing and thumbnil
            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/' . $imageName));
            $img->resize(990);
            $img->save(public_path('uploads/books/thumb/' . $imageName));
        }
        return redirect()->route('books.index')->with('status','book Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = book::find($id);
        return view('books.edit',compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
        if(!empty($request->image)){
            $rules['image'] = 'image';
        }
        $validator = validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        };

        
        $book = book::find($request->id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->save();
        // here we will upload image

        if (!empty($request->image)) {
 
          //for delete old file
          File::delete(public_path('uploads/books/' .$book->image));
          File::delete(public_path('uploads/books/thumb/' .$book->image));

          $image = $request->file('image');
          $ext = $image->getClientOriginalExtension();
          $imageName = time() . '.' . $ext;
          $image->move(public_path('uploads/books'), $imageName);
          $book->image = $imageName;
          $book->save();
        //for images resizing and thumbnil
          $manager = new ImageManager(Driver::class);
          $img = $manager->read(public_path('uploads/books/' . $imageName));
          $img->cover(150, 150);
          $img->save(public_path('uploads/books/thumb/' . $imageName));
      }
        return redirect()->route('books.index')->with('status',' Books Updated Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
{
    // Find the book by ID
    $book = Book::find($request->id);

    // Check if the book exists
    if ($book === null) {
        // Flash error message and return JSON response
        session()->flash('error', 'Book not Found');
        return response()->json([
            'status' => false,
            'message' => 'Book not found'
        ]);
    } else {
        // Delete associated files
        $imagePath = 'uploads/books/' . $book->image;
        $thumbPath = 'uploads/books/thumb/' . $book->image;

        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }

        if (File::exists(public_path($thumbPath))) {
            File::delete(public_path($thumbPath));
        }

        // Delete the book
        $book->delete();

        // Flash success message and return JSON response
        session()->flash('status', 'Book deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Book deleted successfully'
        ]);
    }
}
 
public function saveReview(){
    
    
}
    
}
