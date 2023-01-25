<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin routes
Route::get('/only-admin', function(){
    // if(Gate::allows('validateAdmin')){
    //     return "¡Sos un administrador!";
    // }
    // return "¡No sos un administrador!";
    return "¡Sos un administrador!";
})->middleware('can:validateAdmin');

// User routes
Route::get('/', [UserController::class, "showCorrectHomePage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');

// Blog post routes
Route::get('/create-post', [BlogPostController::class, "showCreateForm"])->middleware('mustBeLoggedIn');
Route::post('/create-post', [BlogPostController::class, "storeNewPost"])->middleware('auth');
Route::get('/post/{post}', [BlogPostController::class, "viewSinglePost"]);
Route::delete('/post/{post}', [BlogPostController::class, "deletePost"])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [BlogPostController::class, "showEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [BlogPostController::class, "editPost"])->middleware('can:update,post');
Route::get('/search/{term}', [BlogPostController::class, "search"]);

// Profile routes
Route::get('/manage-avatar', [ProfileController::class, "showAvatarForm"])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [ProfileController::class, "storeAvatar"])->middleware('mustBeLoggedIn');

Route::get('/profile/{user:username}', [ProfileController::class, "showProfile"])->middleware('mustBeLoggedIn');
Route::get('/profile/{user:username}/followers', [ProfileController::class, "showProfileFollowers"])->middleware('mustBeLoggedIn');
Route::get('/profile/{user:username}/following', [ProfileController::class, "showProfileFollowing"])->middleware('mustBeLoggedIn');

Route::middleware('cache.headers:public;max_age=20;etag')->group(function(){
    Route::get('/profile/{user:username}/raw', [ProfileController::class, "showProfileRaw"])->middleware('mustBeLoggedIn');//->middleware('cache.headers:public;max_age=20;etag');
    Route::get('/profile/{user:username}/followers/raw', [ProfileController::class, "showProfileFollowersRaw"])->middleware('mustBeLoggedIn');
    Route::get('/profile/{user:username}/following/raw', [ProfileController::class, "showProfileFollowingRaw"])->middleware('mustBeLoggedIn');
});

// Follow routes
Route::post('/create-follow/{user:username}', [FollowController::class, "createFollow"])->middleware('mustBeLoggedIn');
Route::post('/remove-follow/{user:username}', [FollowController::class, "removeFollow"])->middleware('mustBeLoggedIn');

// Chat routes
Route::post('/send-chat-message', [ChatController::class, "sendMessage"])->middleware('mustBeLoggedIn');