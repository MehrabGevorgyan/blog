<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Post\LikeController;

Route::redirect('/','/posts');

Route::fallback( fn() => response()->view('home'));

// registration
Route::get('/register',[RegisterController::class,'create'])->middleware('guest')->name('auth.register');
Route::post('/register',[RegisterController::class,'store'])->middleware('guest')->name('auth.store');

// log in
Route::get('/login',[LoginController::class,'create'])->middleware('guest')->name('auth.login');
Route::post('/login',[LoginController::class,'login'])->middleware('guest')->name('auth.login');
Route::get('/logout',[LoginController::class,'logout'])->middleware('auth')->name('auth.logout');


// crud
Route::resource('/posts', PostController::class);


// search posts by user name
Route::get('/user/{user_id}/allposts',[PostController::class,'userAllPosts'])->name('user.allposts');
Route::post('/posts/search',[PostController::class,'postsSearch'])->middleware('auth')->name('posts.search');

//search posts by post tag
Route::get('/posts/tag/{tag_id}',[PostController::class,'getPostsByTag'])->middleware('auth')->name('posts.tag');


// add like,dislike
Route::post('posts/{post_id}/{user_id}/like',[LikeController::class,'addLike'])->middleware('auth');
Route::post('posts/{post_id}/{user_id}/dislike',[LikeController::class,'addDislike'])->middleware('auth');

// add comment
Route::post('posts/{post_id}/{user_id}/addComment',[Postcontroller::class,'addComment'])->middleware('auth')->name('posts.addComment');
Route::post('/orderBy',[Postcontroller::class,'orderBy'])->middleware('auth')->name('orderBy');

Route::delete('deleteUser/{user_id}',[Postcontroller::class,'deleteUser'])->middleware('auth')->name('delete.user');