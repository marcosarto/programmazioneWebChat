<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home',[App\Http\Controllers\HomeController::class,'index']);
Route::get('conversation/{userId}',[App\Http\Controllers\MessageController::class,'conversation'])
    ->name('message.conversation');
//seguendo le linee guida restful api la risorsa sara'
//Path : /photo/{photo} dove photo e' la risorsa
//Route name : photo.show2

Route::get('profile/{userId}', [App\Http\Controllers\ProfilesController::class, 'profile'])->name('profile.show');
Route::get('edit/{id}',[App\Http\Controllers\ProfilesController::class, 'edit']);
Route::get('delete/{id}',[App\Http\Controllers\ProfilesController::class, 'delete']);
Route::post('edit',[App\Http\Controllers\ProfilesController::class, 'update']);

Route::post('send-message','App\Http\Controllers\MessageController@sendMessage')
    ->name('message.send-message');
Route::post('send-group-message','App\Http\Controllers\MessageController@sendGroupMessage')
    ->name('message.send-group-message');



Route::resource('message-groups', 'App\Http\Controllers\MessageGroupController');
