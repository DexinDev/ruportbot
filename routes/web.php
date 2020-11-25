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

Route::match(['get', 'post'], '/', ['uses'=> 'AuthController@view'])->middleware('auth');
Route::match(['get', 'post'], '/updateMembers', ['uses'=> 'ChatMembersController@updateMembers'])->middleware('auth');
//Route::match(['get', 'post'], '/runMessageListener', ['uses'=> 'MessageListenerController@start'])->middleware('auth');
Route::match(['get', 'post'], '/stopMessageListener', ['uses'=> 'MessageListenerController@stop'])->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
