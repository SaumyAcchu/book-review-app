<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/book/{id}',[HomeController::class,'detail'])->name('home.detail');
Route::post('/book/saveReview',[HomeController::class,'saveReview'])->name('home.saveReview');

Route::group(['prefix'=> 'account'], function(){
    Route::group(['middleware' =>'guest'], function(){
        Route::get('register',[AccountController::class,'register'])->name('account.register');
        Route::post('processRegister',[AccountController::class,'processRegister'])->name('account.processRegister');
        Route::get('login',[AccountController::class,'login'])->name('account.login');
        Route::post('authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' =>'auth'], function(){
        Route::get('profile',[AccountController::class,'profile'])->name('account.profile');
        Route::get('logout',[AccountController::class,'logout'])->name('account.logout');
        Route::post('update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');

        Route::group(['middleware' => 'check-admin'], function(){
            Route::get('books',[BookController::class,'index'])->name('books.index');
            Route::get('books/create',[BookController::class,'create'])->name('books.create');
            Route::post('books/store',[BookController::class,'store'])->name('books.store');
            Route::get('books/edit/{id}',[BookController::class,'edit'])->name('books.edit');
            Route::post('books/update/{id}',[BookController::class,'update'])->name('books.update');
            Route::delete('books',[BookController::class,'destroy'])->name('books.destroy');
            Route::get('review',[ReviewController::class,'index'])->name('review.index');
            Route::get('review/edit/{id}',[ReviewController::class,'edit'])->name('review.edit');
            Route::post('review/update/{id}',[ReviewController::class,'update'])->name('review.update');
            Route::delete('review',[ReviewController::class,'delete'])->name('review.delete');
        });

        Route::get('review/my-review',[ReviewController::class,'myReview'])->name('review.myReview');
        Route::delete('review/my-review',[ReviewController::class,'myReview_delete'])->name('review.myReview_delete');
        Route::get('review/myReview_edit/{id}',[ReviewController::class,'myReview_edit'])->name('review.myReview_edit');
        Route::post('review/myReview_update/{id}',[ReviewController::class,'myReview_update'])->name('review.myReview_update');
        
        
    });
});