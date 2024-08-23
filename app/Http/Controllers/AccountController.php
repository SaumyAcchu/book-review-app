<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;


class AccountController extends Controller
{
    public function register(){
      return view('account.register');       
    }
    public function processRegister(Request $request){
        $validator = validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:3',
            'password_confirmation' => 'required',
         ]);
         if ($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput(); }
        $user = new user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        if($user){
          return redirect()->route('account.login')
                           ->with('status',' User Registered Successfully.');
        }

    }

    public function login(){
      return view('account.login');

    }
    public function authenticate(Request $request){
      $validator = validator::make($request->all(),[
        'email' => 'required|email',
        'password' => 'required',
     ]);
    
     if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput(); 
        }
      if(Auth::attempt(['email' =>  $request->email, 'password' => $request->password])){
        return redirect()->route('account.profile');
      }else{
        return redirect()->back()->withErrors($validator)->withInput()->with('error',' Either email/password is incorrect.'); 
      }

           
    }

    public function profile()
    {
      return view('account.profile');
    }
    public function updateProfile(Request $request){
      $rules = [
        'name' =>'required',
        'email' =>'required|email|unique:users,email,'.Auth::user()->id.',id',
      ];
      if(!empty($request->image)){
        $rules['image'] = 'image';
      }
      $validator = validator::make($request->all(),$rules);
      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput(); 
          }
        $user = user::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        // here we will upload image

        if (!empty($request->image)) {
 
          //for delete old file
          File::delete(public_path('uploads/profile/' .$user->image));
          File::delete(public_path('uploads/profile/thumb/' .$user->image));


          // Get the uploaded image file from the request
          $image = $request->file('image');
          
          // Retrieve the original extension of the uploaded image
          $ext = $image->getClientOriginalExtension();
          
          // Generate a unique filename for the image
          $imageName = time() . '.' . $ext;
          
          // Move the uploaded image to the 'uploads/profile' directory
          $image->move(public_path('uploads/profile'), $imageName);
          
          // Update the user's image attribute with the new filename
          $user->image = $imageName;
          
          // Save the user record with the updated image filename
          $user->save();


          //for images resizing and thumbnil
          $manager = new ImageManager(Driver::class);
          $img = $manager->read(public_path('uploads/profile/' . $imageName));
          $img->cover(150, 150);
          $img->save(public_path('uploads/profile/thumb/' . $imageName));
      }
        return redirect()->route('account.profile')->with('status',' Profile Updated Successfully.');


    }
    public function logout(){
      Auth::logout();
      return redirect()->route('account.login');
  }
}
